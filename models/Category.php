<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii;

/**
* 题目分类数据模型
*/
class Category extends ActiveRecord
{
    /**
     * return table name
     * @return string table name
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * 添加一个分类数据
     * @param   string    $categoryname 分类名
     * @return  integer|boolean         插入数据的 ID | FALSE
     */
    public static function addOneCategory( $categoryname )
    {
        $category = new Category( ['categoryname' => $categoryname] );
        return $category->save() ? $category->categoryid : FALSE;
    }

    /**
     * 获取所有的分类数据
     * @return array 分类数据数组
     */
    public static function getAllCategory()
    {
        return self::find()->asArray()->all();
    }
}