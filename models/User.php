<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * 普通管理员权限
     */
    const MANAGER = 2;

    /**
     * 学生权限
     */
    const STUDENT = 3;
    
    /**
     * return table name
     * @return string table name
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne( $id );
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        // return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::getOneUserByCondition( ['username' => $username] );
        return !empty( $user ) ? $user : NULL;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5( md5( $password ) . $this->salt );
    }

    /**
     * 添加一个新用户
     * @param array $attributes 用户信息数组
     * @return boolean TRUE | FALSE
     */
    public static function addOneUser( $attributes )
    {
        $user = new User( $attributes );
        return $user->save();
    }

    /**
     * 根据用户 ID 获取一条用户数据
     * @param  integer $uid 用户 ID
     * @return object      AR
     */
    public static function getOneUserById( $uid )
    {
        return self::getOneUserByCondition( ['id' => $uid] );
    }

    /**
     * 根据查询条件获取一条用户数据
     * @param  string|array $condition 查询条件
     * @return object            AR
     */
    public static function getOneUserByCondition( $condition )
    {
        return self::find()->where( $condition )->one();
    }

    /**
     * 根据权限等级获取所有的用户数据
     * @param  integer $permission 权限等级
     * @return array               用户数据数组
     */
    public static function getAllUserByPermission( $permission )
    {
        return self::getAllUserByCondition( ['permission' => $permission] );
    }

    /**
     * 根据查询条件获取所有的用户数据
     * @param  string|array $condition 查询条件
     * @return array                   用户数据数组
     */
    public static function getAllUserByCondition( $condition )
    {
        return self::find()->where( $condition )->all();
    }

    /**
     * 根据用户 ID 更新用户信息
     * @param  integer  $uid        用户 ID
     * @param  array    $attributes 需要更新的用户数据
     * @return boolean              TRUE | FALSE
     */
    public static function updateUserByUid( $uid, $attributes )
    {
        if ( !empty( $attributes['password'] ) )
        {
            $user = self::findOne( $uid );
            $attributes['password'] = md5( md5( $attributes['password'] ) . $user['salt'] );
        }
        else
            unset( $attributes['password'] );

        return self::updateAll( $attributes, ['id' => $uid] ) > 0 ? TRUE : FALSE;
    }

}
