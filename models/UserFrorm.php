<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use app\models\User as UserModel;
use app\components\String;

/**
 * UserFrorm is the model behind the login form.
 */
class UserFrorm extends Model
{
    /**
     * 用户名
     * @var string
     */
    public $username;
    
    /**
     * 密码
     * @var string
     */
    public $password;

    /**
     * 二次输入密码
     * @var string
     */
    public $passwordAgain;

    /**
     * 姓名
     * @var string
     */
    public $name;

    /**
     * 学号
     * @var string
     */
    public $stunum;

    /**
     * 年级
     * @var string
     */
    public $grade;

    /**
     * 系别
     * @var string
     */
    public $faculty;

    /**
     * 专业
     * @var string
     */
    public $specialty;

    /**
     * 记住我
     * @var boolean
     */
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'email', 'captcha'], 'required', 'message' => '内容不能为空'],
            // username 唯一性检查
            ['username', 'usernameOnly', 'on' => 'register'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => 'login'],
            // 注册时两次密码输入要一致
            ['passwordAgain', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入密码不一致'],
        ];
    }

    /**
     * 用户表单模型属性对应 label 值
     * @return array 
     */
    public function attributeLabels()
    {
        return [
            'username'      => '用户名',
            'password'      => '密码',
            'passwordAgain' => '再次输入密码',
            'name'          => '姓名',
            'rememberMe'    => '记住我',
            'stunum'        => '学号',
            'grade'         => '年级',
            'faculty'       => '系别',
            'specialty'     => '专业',
        ];
    }

    /**
     * 场景
     * @return array 不同场景下的激活属性
     */
    public function scenarios()
    {
        return [
            'login'     => ['username', 'password', 'rememberMe'],
            'register'  => ['username', 'password', 'passwordAgain', 'name', 'stunum', 'grade', 'faculty', 'specialty'],
        ];
    }

    /**
     * 检查对应信息是否已被其他用户注册
     */
    public function isExist()
    {
        if ( !empty( UserModel::findOne( ['username' => Html::encode( $this->username )] ) ) )
            $this->addError( 'username', '用户名已被注册' );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if ( !$this->hasErrors() )
        {
            $user = $this->getUser();

            if ( !$user || !$user->validatePassword( $this->password ) )
                $this->addError( $attribute, '用户名或密码错误' );
        }
    }

    /**
     * 用户注册
     * @return boolean TRUE | FALSE
     */
    public function register()
    {
        if ( $this->validate() )
        {
            $salt = String::generateRandomString( 6 );
            $user = [
                'username'      => Html::encode( $this->username ),
                'password'      => md5( md5( $this->password ) . $salt ),
                'salt'          => $salt,
                'worknum'       => String::generateRandomString( 15 ),
                'name'          => Html::encode( $this->name ),
                'status'        => 1,
                'permission'    => 3,
                'extra'         => $this->handleExtra(),
            ];
            return UserModel::addOneUser( $user );
        }
        else
            return FALSE;
    }

    /**
     * 处理用户额外数据
     * @return array 
     */
    private function handleExtra()
    {
        $extra = [
            'stunum'    => $this->stunum,
            'grade'     => $this->grade,
            'faculty'   => $this->faculty,
            'specialty' => $this->specialty,
        ];

        return serialize( $extra );
    }

    /**
     * 用户登录处理
     * @return boolean TRUE | FALSE
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * 根据账号获取用户数据
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * 用户名唯一性检查
     */
    public function usernameOnly()
    {
        $user = UserModel::getOneUserByCondition( ['username' => $this->username] );
        if ( !empty( $user ) )
            $this->addError( 'username', '用户名已被使用' );
    }
}
