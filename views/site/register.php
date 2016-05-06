<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '用户注册';
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#get-captcha-button').click(function(){
        $.ajax({
            url: '/index.php?r=api/sendemailcaptcha',
            type: 'post',
            data: { email: $('#userfrorm-email').val(), _csrf: $('input[name=_csrf]').val() },
            dataType: 'json',
            error: function( data ) {
                notify( data );
            },
            success: function( res ) {
                notify( res.msg );
            }
        })
    })
})
</script>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field( $userForm, 'name' ) ?>

                    <?= $form->field( $userForm, 'username' ) ?>

                    <?= $form->field( $userForm, 'password' )->passwordInput() ?>

                    <?= $form->field( $userForm, 'passwordAgain' )->passwordInput() ?>

                    <div class="form-group field-userfrorm-email required">
                        <label class="control-label" for="userfrorm-email">邮箱</label>
                        <div class="input-group">
                            <input type="text" id="userfrorm-email" class="form-control" name="UserFrorm[email]">

                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="get-captcha-button">获取验证码</button>
                            </span>
                        </div>
                        <p class="help-block help-block-error"></p>
                    </div>

                    <?= $form->field( $userForm, 'captcha' ) ?>

                    <?= $form->field( $userForm, 'stunum' ) ?>

                    <?= $form->field( $userForm, 'grade' ) ?>

                    <?= $form->field( $userForm, 'faculty' ) ?>

                    <?= $form->field( $userForm, 'specialty' ) ?>

                    <div class="form-group">
                        <?= Html::submitButton( '注册', ['class' => 'btn btn-primary btn-block', 'name' => 'contact-button'] ) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

</div>
