<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii;

/**
* 题库数据模型
*/
class Topic extends ActiveRecord
{
    /**
     * return table name
     * @return string table name
     */
    public static function tableName()
    {
        return '{{%topic}}';
    }

    /**
     * 题目分类关联关系
     */
    public function getCategory()
    {
        return $this->hasOne( Category::className(), ['categoryid' => 'categoryid'] );
    }

    /**
     * 获取一条题目数据
     * @param  integer $topicid 题目 ID
     * @return array            题目数据数组
     */
    public static function getOneTopic( $topicid )
    {
        return self::find()->joinWith( 'category' )->where( ['id' => $topicid] )->asArray()->one();
    }

    /**
     * 分页获取所有的题目信息
     * @param  integer $pageSize 每页最大显示数
     * @return array             ['topicArr' => [题目数据数组], 'pages' => 分页类]
     */
    public static function getAllTopic( $pageSize = 20 )
    {
        $query = self::find();
        $pages = new Pagination( ['totalCount' => $query->count(), 'defaultPageSize' => $pageSize] );
        $topicArr = $query->joinWith( 'category' )
            ->orderBy( 'id DESC' )
            ->offset( $pages->offset )
            ->limit( $pages->limit )
            ->asArray()
            ->all();
        return ['topicArr' => $topicArr, 'pages' => $pages];
    }

    /**
     * 添加一条题目数据
     * @param array $attributes 题目数据数组
     * [
     *     'subject'    => 题目内容,
     *     'categoryid' => 分类 ID,
     *     'option_a'   => A 选项,
     *     'option_b'   => B 选项,
     *     'option_c'   => C 选项,
     *     'option_d'   => D 选项,
     *     'answer'     => 正确答案
     * ];
     * @return boolean TRUE | FALSE
     */
    public static function addOneTopic( $attributes )
    {
        $topic = new Topic( $attributes );
        return $topic->save();
    }

    /**
     * 更新一条题目数据
     * @param  integer  $topicid    题目 ID
     * @param  array    $attributes 更新的数据数组
     * @return boolean              TRUE | FALSE
     */
    public static function updateOneTopic( $topicid, $attributes )
    {
        return self::updateAll( $attributes, ['id' => $topicid] ) > 0 ? TRUE : FALSE;
    }

    /**
     * 根据分类 ID 获取所有的试题 ID
     * @return array 试题 ID 数组
     */
    public static function getAllTopicidByCategoryid( $categoryid = 0 )
    {
        $query = self::find()->select( 'id' );
        if ( $categoryid !== 0 )
            $query = $query->where( ['categoryid' => $categoryid] );
        return $query->asArray()->all();
    }
}