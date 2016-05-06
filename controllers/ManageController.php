<?php

namespace app\controllers;

use app\models\User;
use app\models\MarkdownForm;
use app\models\Setting;
use app\models\Topic;
use app\models\Category;
use app\models\Exam;
use yii\helpers\Markdown;
use yii\web\Controller;
use yii\helpers\Html;
use yii;
use PHPExcel;

/**
* 后台管理控制器
*/
class ManageController extends Controller
{
    /**
     * 权限过滤
     */
    public function beforeAction( $action )
    {
        if ( $action->id !== 'error' && ( yii::$app->user->isGuest || yii::$app->user->identity->permission === 3 ) )
            $this->redirect( ['error', 'name' => Html::encode( '权限错误' ), 'msg' => '抱歉，您没有权限进行操作'] );
        return parent::beforeAction( $action );
    }

    /**
     * 后台首页
     */
    public function actionIndex()
    {
        $managerArr = User::getAllUserByPermission( User::MANAGER );
        $studentArr = User::getAllUserByPermission( User::STUDENT );
        return $this->render( 'index', [
            'managerArr'    => $managerArr,
            'studentArr'    => $studentArr,
        ] );
    }

    /**
     * 统计信息
     */
    public function actionGraphinfo()
    {
        # todo 你需要对统计信息数据进行的处理
        return $this->render( 'graphinfo' );
    }

    /**
     * 题库管理
     */
    public function actionTopic()
    {
        $topicList = Topic::getAllTopic();
        return $this->render( 'topic', [
            'topicArr'  => $topicList['topicArr'],
            'pages'     => $topicList['pages'],
            'isImport'  => $isImport,
        ] );
    }

    /**
     * 题目编辑
     */
    public function actionTopicedit()
    {
        $topicid = yii::$app->request->getQueryParam( 'topicid' );
        if ( empty( $topicid ) )
            $this->redirect( ['error', 'name' => Html::encode( '非法的参数' ), 'msg' => '请检查提交的参数是否正确'] );

        return $this->render( 'topicedit', [
            'topic'         => Topic::getOneTopic( $topicid ),
            'categoryArr'   => Category::getAllCategory(),
        ] );
    }

    /**
     * 考试管理
     */
    public function actionExam()
    {
        $examrule = Setting::getOneValueByKey( 'examrule' );
        if ( is_null( $examrule ) )
        {
            $examrule = ['topicCount' => 20, 'categoryTopic' => [['id' => 0, 'num' => 20, 'scores' => 5]]];
            // 如果设置数据不存在则默认添加一条随机选择 20 道题目的规则
            Setting::addOneKeyValue( 'examrule', serialize( $examrule ) );
        }

        return $this->render( 'exam', [
            'examrule'      => unserialize( $examrule ),
            'categoryArr'   => Category::getAllCategory(),
        ] );
    }

    /**
     * 文章管理
     */
    public function actionArticle()
    {
        $article = unserialize( Setting::getOneValueByKey( 'article' ) );
        $index = unserialize( Setting::getOneValueByKey( 'index' ) );
        return $this->render( 'article', [
            'notify'    => $index['notify'],
            'title'     => $article['title'],
            'content'   => $article['content']
        ] );
    }

    /**
     * 信息搜索
     */
    public function actionSearch()
    {
        # todo 信息搜索
    }

    /**
     * 超管添加人员
     */
    public function actionAdduser()
    {
        return $this->render( 'adduser' );
    }

    /**
     * 用户编辑
     */
    public function actionUseredit()
    {
        $uid = yii::$app->request->getQueryParam( 'uid' );
        if ( empty( $uid ) )
            $this->redirect( ['error', 'name' => Html::encode( '非法的参数' ), 'msg' => '请检查提交的参数是否正确'] );

        return $this->render( 'useredit', ['user' => User::getOneUserById( $uid )] );
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