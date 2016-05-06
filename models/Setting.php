<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii;

/**
* 系统设置表数据模型
*/
class Setting extends ActiveRecord
{
	/**
     * return table name
     * @return string table name
     */
	public static function tableName()
	{
		return '{{%setting}}';
	}

	/**
	 * 保存一条键值对数据
	 * @param string $key   键
	 * @param string $value 值
	 * @return boolean TRUE | FALSE
	 */
	public static function addOneKeyValue( $key, $value )
	{
		$setting = new Setting();
		$setting->key = $key;
		$setting->value = $value;
		return $setting->save();
	}

	/**
	 * 根据键返回对应的值
	 * @param  string $key 键
	 * @return string      值
	 */
	public static function getOneValueByKey( $key )
	{
		$setting = self::find()->where( ['key' => $key] )->one();
		return !empty( $setting ) ? $setting->value : NULL;
	}

	/**
	 * 根据键更新值
	 * @param  string $key   键
	 * @param  string $value 值
	 * @return boolean       TRUE | FALSE
	 */
	public static function updateOneValueByKey( $key, $value )
	{
		$setting = self::find()->where( ['key' => $key] )->one();
		if ( empty( $setting ) )
			return FALSE;
		$setting->value = $value;
		return $setting->update();
	}
}