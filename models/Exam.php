<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii;

/**
* 考试数据模型类
*/
class Exam extends ActiveRecord
{
    /**
     * return table name
     * @return string table name
     */
    public static function tableName()
    {
        return '{{%exam}}';
    }

    /**
     * 添加一条考试信息数据
     * @param  array    $attributes 考试信息数组
     * @return boolean              TRUE | FALSE
     */
    public static function addOneExam( $attributes )
    {
        $exam = new Exam( $attributes );
        return $exam->save();
    }

    /**
     * 查询符合条件的考试数据数量
     * @param  string|array $condition  查询条件
     * @return integer                  数据数量
     */
    public static function getCountByCondition( $condition = '' )
    {
        $query = self::find();
        if ( !empty( $condition ) )
            $query = $query->where( $condition );
        return $query->count();
    }

    /**
     * 按照成绩段分组进行统计人数
     * @return array 统计结果
     */
    public static function getCountWithScoreSection()
    {
        $result[] = intval( self::find()->where( '`score` >= 0 AND `score` <= 9' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 10 AND `score` <= 19' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 20 AND `score` <= 29' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 30 AND `score` <= 39' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 40 AND `score` <= 49' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 50 AND `score` <= 59' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 60 AND `score` <= 69' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 70 AND `score` <= 79' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 80 AND `score` <= 89' )->count() );
        $result[] = intval( self::find()->where( '`score` >= 90 AND `score` <= 99' )->count() );
        $result[] = intval( self::find()->where( '`score` = 100' )->count() );
        return $result;
    }
}