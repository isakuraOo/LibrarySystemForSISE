<?php

namespace app\components;

use yii\base\Component;
use yii\helpers\Json;
use yii;

/**
* 消息工具类
*/
class Message extends Component
{
    /**
     * ajax 返回状态为 FALSE 的数据
     * @param  string $msg 错误信息内容
     */
    public function ajaxReturnError( $msg = '' )
    {
        exit( Json::encode( ['status' => FALSE, 'msg' => $msg] ) );
    }

    /**
     * ajax 返回状态为 TRUE 的数据
     * @param  string $msg  处理结果内容
     * @param  array  $data 需要返回的数据
     */
    public function ajaxReturnSuccess( $msg = '', $data = [] )
    {
        exit( Json::encode( ['status' => TRUE, 'msg' => $msg, 'data' => $data] ) );
    }
}