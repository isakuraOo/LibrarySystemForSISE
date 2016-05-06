<?php

namespace app\controllers;

use app\components\String;
use app\models\Setting;
use app\models\User;
use app\models\Category;
use app\models\Topic;
use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\Html;
use yii;

/**
* API 相关调用控制器
*/
class ApiController extends Controller
{
    /**
     * 动作执行前的过滤
     */
    public function beforeAction( $action )
    {
        $request = yii::$app->request;
        if ( !$request->isAjax )
            yii::$app->message->ajaxReturnError( '请使用 AJAX 方式进行调用' );
        else
            return parent::beforeAction( $action );
    }

    /**
     * 保存文章
     * @return json 调用结果
     */
    public function actionSavearticle()
    {
        $post = yii::$app->request->post();
        if ( empty( $post['title'] ) || empty( $post['content'] ) )
            yii::$app->message->ajaxReturnError( '标题、正文 内容不能为空' );
        else
        {
            $value = serialize( ['title' => Html::encode( $post['title'] ), 'content' => $post['content']] );
            $updateRes = Setting::updateOneValueByKey( 'article', $value );
            if ( $updateRes )
                yii::$app->message->ajaxReturnSuccess( '更新成功' );
            else
                yii::$app->message->ajaxReturnError( '更新失败' );
        }
    }

    /**
     * 保存首页公告
     * @return json 调用结果
     */
    public function actionSaveindexnotify()
    {
        $post = yii::$app->request->post();
        if ( empty( $post['notify'] ) )
            yii::$app->message->ajaxReturnError( '公告内容内容不能为空' );
        else
        {
            $index = unserialize( Setting::getOneValueByKey( 'index' ) );
            $value = serialize( array_merge( $index, ['notify' => Html::encode( $post['notify'] )] ) );
            $updateRes = Setting::updateOneValueByKey( 'index', $value );
            if ( $updateRes )
                yii::$app->message->ajaxReturnSuccess( '更新成功' );
            else
                yii::$app->message->ajaxReturnError( '更新失败' );
        }
    }

    /**
     * 更新用户数据
     * @return json 调用结果
     */
    public function actionUpdateuser()
    {
        $post = yii::$app->request->post();
        if ( empty( yii::$app->request->getBodyParam( 'uid' ) ) )
            yii::$app->message->ajaxReturnError( '提交的参数有误' );
        if ( !empty( $post['password'] ) && strcasecmp( $post['password'], $post['passwordAgain'] ) !== 0 )
            yii::$app->message->ajaxReturnError( '两次输入的密码不一致' );

        // 更新管理员信息
        if ( isset( $post['worknum'] ) )
        {
            // 超管才能修改普通管理员信息
            if ( yii::$app->user->identity->permission !== 3 )
                yii::$app->message->ajaxReturnError( '抱歉，您没有权限进行操作' );

            $attributes = [
                'worknum'   => Html::encode( $post['worknum'] ),
                'name'      => Html::encode( $post['name'] ),
                'password'  => $post['password'],
            ];
        }
        // 更新学生信息
        elseif ( isset( $post['stunum'] ) )
        {
            $attributes = [
                'name'      => Html::encode( $post['name'] ),
                'extra'     => serialize( [
                    'stunum'    => Html::encode( $post['stunum'] ),
                    'grade'     => Html::encode( $post['grade'] ),
                    'faculty'   => Html::encode( $post['faculty'] ),
                    'specialty' => Html::encode( $post['specialty'] ),
                ] ),
                'password'  => $post['password'],
            ];
        }
        else
            yii::$app->message->ajaxReturnError( '更新失败' );

        $updateRes = User::updateUserByUid( $post['uid'], $attributes );
        if ( $updateRes )
            yii::$app->message->ajaxReturnSuccess( '更新成功' );
        else
            yii::$app->message->ajaxReturnError( '更新失败' );
    }

    /**
     * 添加一个管理员用户
     * @return json 调用结果
     */
    public function actionAddmanager()
    {
        $post = yii::$app->request->post();
        if ( !isset( $post['username'] ) )
            yii::$app->message->ajaxReturnError( '提交的参数有误' );
        if ( empty( $post['username'] ) )
            yii::$app->message->ajaxReturnError( '账号不能为空' );

        $salt = String::generateRandomString( 6 );
        $attributes = [
            'username'      => $post['username'],
            'worknum'       => isset( $post['worknum'] ) && !empty( $post['worknum'] ) ? Html::encode( $post['worknum'] ) : String::generateRandomString( 15 ),
            'name'          => isset( $post['name'] ) ? Html::encode( $post['name'] ) : '',
            'password'      => md5( md5( '123456' ) . $salt ),
            'salt'          => $salt,
            'permission'    => User::MANAGER,
        ];
        $addRes = User::addOneUser( $attributes );
        if ( $addRes )
            yii::$app->message->ajaxReturnSuccess( '添加成功' );
        else
            yii::$app->message->ajaxReturnError( '添加失败' );
    }

    /**
     * 更新一条题目数据
     * @return json 调用结果
     */
    public function actionUpdatetopic()
    {
        $post = yii::$app->request->post();
        if ( !isset( $post['topicid'] ) || empty( $post['topicid'] ) || !isset( $post['categoryid'] ) || !isset( $post['subject'] ) || !isset( $post['option_a'] ) || !isset( $post['option_b'] ) || !isset( $post['option_c'] ) || !isset( $post['option_d'] ) || !isset( $post['answer'] ) )
            yii::$app->message->ajaxReturnError( '提交的参数有误' );

        if ( empty( $post['subject'] ) || empty( $post['answer'] || empty( $post['categoryid'] ) ) )
            yii::$app->message->ajaxReturnError( '修改的内容不能为空' );

        if ( empty( Category::findOne( $post['categoryid'] ) ) )
            yii::$app->message->ajaxReturnError( '更新失败' );

        $attributes = [
            'subject'       => Html::encode( $post['subject'] ),
            'categoryid'    => intval( $post['categoryid'] ),
            'option_a'      => Html::encode( $post['option_a'] ),
            'option_b'      => Html::encode( $post['option_b'] ),
            'option_c'      => Html::encode( $post['option_c'] ),
            'option_d'      => Html::encode( $post['option_d'] ),
            'answer'        => Html::encode( $post['answer'] ),
        ];
        $updateRes = Topic::updateOneTopic( intval( $post['topicid'] ), $attributes );
        if ( $updateRes )
            yii::$app->message->ajaxReturnSuccess( '更新成功' );
        else
            yii::$app->message->ajaxReturnError( '更新失败' );
    }

    /**
     * 更新考试题目设置
     * @return json 调用结果
     */
    public function actionUpdateexamrule()
    {
        $post = yii::$app->request->post();
        if ( !isset( $post['examrule'] ) )
            yii::$app->message->ajaxReturnError( '提交的参数有误' );

        $numCount = 0;
        $scoresCount = 0;
        foreach ( $post['examrule']['categoryTopic'] as $key => $categoryTopic )
        {
            if ( empty( $categoryTopic['num'] ) || empty( $categoryTopic['scores'] ) )
            {
                unset( $post['examrule']['categoryTopic'][$key] );
                continue;
            }

            $numCount += intval( $categoryTopic['num'] );
            $scoresCount += intval( $categoryTopic['scores'] * $categoryTopic['num'] );
        }
        if ( $numCount !== intval( $post['examrule']['topicCount'] ) )
            yii::$app->message->ajaxReturnError( '题目数量设置有误' );
        if ( $scoresCount !== 100 )
            yii::$app->message->ajaxReturnError( '题目总分必须为 100 分' );

        if ( Setting::updateOneValueByKey( 'examrule', serialize( $post['examrule'] ) ) )
            yii::$app->message->ajaxReturnSuccess( '设置成功' );
        else
            yii::$app->message->ajaxReturnError( '设置失败' );
    }
}