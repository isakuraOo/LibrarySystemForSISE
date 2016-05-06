<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\UserFrorm;
use app\models\ContactForm;
use app\models\Setting;
use app\models\Category;
use app\models\Exam;
use app\models\Topic;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 考试必须登录
     */
    public function beforeAction( $action )
    {
        if ( $action->id === 'exam' && yii::$app->user->isGuest )
            $this->redirect( ['login'] );
        return parent::beforeAction( $action );
    }

    /**
     * 首页动作
     */
    public function actionIndex()
    {
        $index = unserialize( Setting::getOneValueByKey( 'index' ) );
        return $this->render( 'index', ['notify' => $index['notify']] );
    }

    /**
     * 登录动作
     */
    public function actionLogin()
    {
        if ( !yii::$app->user->isGuest ) {
            return $this->goHome();
        }

        $userForm = new UserFrorm( ['scenario' => 'login'] );
        if ( $userForm->load( yii::$app->request->post() ) && $userForm->login() ) {
            return $this->goBack();
        }
        return $this->render( 'login', ['userForm' => $userForm] );
    }

    /**
     * 注册动作
     */
    public function actionRegister()
    {
        $userForm = new UserFrorm( ['scenario' => 'register'] );
        if ( $userForm->load( yii::$app->request->post() ) && $userForm->register() )
            return $this->redirect( yii::$app->user->getReturnUrl() );

        return $this->render( 'register', ['userForm' => $userForm] );
    }

    /**
     * 退出登陆动作
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 考试须知
     */
    public function actionExamnotify()
    {
        $article = unserialize( Setting::getOneValueByKey( 'article' ) );
        return $this->render( 'examnotify', ['article' => $article] );
    }

    /**
     * 考试
     */
    public function actionExam()
    {
        $request = yii::$app->request;
        if ( $request->isPost || !is_null( yii::$app->session->get( 'examInfo' ) ) )
             return $this->startExam();
        return $this->render( 'exam' );
    }

    /**
     * 开始考试执行动作
     */
    private function startExam()
    {
        // yii::$app->session->remove( 'examInfo' );die;
        $examInfo = yii::$app->session->get( 'examInfo' );
        $post = yii::$app->request->post();
        // 如果是考试刚开始，进行数据初始化
        if ( is_null( $examInfo ) && ( empty( $post['topicid'] ) || empty( $post['answer'] ) ) )
        {
            $examrule = unserialize( Setting::getOneValueByKey( 'examrule' ) );
            if ( empty( $examrule ) || empty( $examrule['categoryTopic'] ) )
                $this->redirect( ['error', 'name' => '设置错误', 'messge' => '请联系管理员设置相应的考试规则'] );

            foreach ( $examrule['categoryTopic'] as $categoryTopic )
            {
                $topicidArr = Topic::getAllTopicidByCategoryid( intval( $categoryTopic['id'] ) );
                $topicidKeyArr = array_rand( $topicidArr, $categoryTopic['num'] );
                foreach ( $topicidKeyArr as $topicidKey )
                    $examInfo['topic'][] = ['topicid' => $topicidArr[$topicidKey]['id'], 'scores' => $categoryTopic['scores']];
            }
            $examInfo['schedule'] = ['numnow' => 0, 'answerArr' => [], 'score' => 0];
            $examInfo['begin_time'] = time();
            yii::$app->session->set( 'examInfo', $examInfo );

        }

        // 第一题不需要进行上一题的答案统计
        if ( !is_null( $examInfo ) && ( empty( $post['topicid'] ) || empty( $post['answer'] ) ) )
        {
            $topic = Topic::getOneTopic( $examInfo['topic'][$examInfo['schedule']['numnow']]['topicid'] );
            return $this->render( 'examtopic', [
                'topic' => $topic,
                'now'   => $examInfo['schedule']['numnow'],
                'count' => count( $examInfo['topic'] ),
            ] );
        }
        else
        {
            $topic = Topic::getOneTopic( $post['topicid'] );
            $answer = implode( '', $post['answer'] );
            $numnow = intval( $post['numnow'] );
            // 对比答案记录成绩
            if ( $answer === $topic['answer'] )
                $examInfo['schedule']['score'] += $examInfo['topic'][$numnow]['scores'];
            $examInfo['schedule']['answerArr'][] = $answer;
            $examInfo['schedule']['numnow']++;

            // 答题结束记录数据
            if ( $examInfo['schedule']['numnow'] == count( $examInfo['topic'] ) )
            {
                yii::$app->session->remove( 'examInfo' );
                $examInfo['end_time'] = time();
                foreach ( $examInfo['topic'] as $topic )
                {
                    $topicidArr[] = $topic['topicid'];
                    $socresArr[] = $topic['scores'];
                }
                $attributes = [
                    'uid'           => yii::$app->user->id,
                    'topicid_str'   => implode( ',', $topicidArr ),
                    'scores_str'    => implode( ',', $socresArr ),
                    'answer_str'    => implode( ',', $examInfo['schedule']['answerArr'] ),
                    'score'         => $examInfo['schedule']['score'],
                    'begin_time'    => $examInfo['begin_time'],
                    'end_time'      => $examInfo['end_time']
                ];
                if ( Exam::addOneExam( $attributes ) )
                    return $this->render( 'examtopic', [
                        'examEnd'   => TRUE,
                        'score'     => $examInfo['schedule']['score'],
                    ] );
                else
                    return $this->redirect( ['error', 'name' => '数据保存出错', 'message' => '考试成绩录入出错'] );
            }

            yii::$app->session->set( 'examInfo', $examInfo );
            $topic = Topic::getOneTopic( $examInfo['topic'][$examInfo['schedule']['numnow']]['topicid'] );
            return $this->render( 'examtopic', [
                'topic' => $topic,
                'now'   => $examInfo['schedule']['numnow'],
                'count' => count( $examInfo['topic'] ),
            ] );
        } 
    }

    /**
     * 错误提示动作
     */
    public function actionError()
    {
        $params = yii::$app->request->getQueryParams();
        return $this->render( 'error', ['name' => $params['name'], 'message' => $params['msg']] );
    }
}
