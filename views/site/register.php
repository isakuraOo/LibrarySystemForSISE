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
