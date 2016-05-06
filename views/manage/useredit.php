<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

$this->title = '用户编辑';
$extra = unserialize( $user['extra'] );
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#update-user-data').click(function(){
        if ( $('#user-password').val() !== '' && $('#user-password').val() !== $('#user-password-again').val() )
        {
            notify( '两次输入的密码不一致' );
            return false;
        }
        
        <?php if ( $user['permission'] == User::MANAGER ): ?>
            var data = {
                _csrf: $('input[name=_csrf]').val(),
                uid: <?= $user['id'] ?>,
                worknum: $('#manager-worknum').val(),
                name: $('#manager-name').val(),
                password: $('#user-password').val(),
                passwordAgain: $('#user-password-again').val(),
            };
        <?php elseif ( $user['permission'] == User::STUDENT ): ?>
            var data = {
                _csrf: $('input[name=_csrf]').val(),
                uid: <?= $user['id'] ?>,
                stunum: $('#student-stunum').val(),
                name: $('#student-name').val(),
                grade: $('#student-grade').val(),
                faculty: $('#student-faculty').val(),
                specialty: $('#student-specialty').val(),
                password: $('#user-password').val(),
                passwordAgain: $('#user-password-again').val(),
            };
        <?php endif; ?>
        $.ajax({
            url: '<?= Url::to( ['api/updateuser'] ) ?>',
            type: 'post',
            data: data,
            dataType: 'json',
            error: function( data ) {
                notify( data );
            },
            success: function( res ) {
                notify( res.msg );
                if ( res.status )
                    setTimeout( function(){
                        window.location.href = '<?= Url::to( ['manage/index'] ) ?>';
                    }, 2000 );
            }
        });
    });
});
</script>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'default'] ) ?>
    <div class="col-xs-10">
    
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <?php if ( $user['permission'] == User::MANAGER ): ?>
            <!-- 管理员 -->
            <div class="form-group col-xs-8">
                <label class="control-label" for="manager-worknum">工号</label>
                <input type="text" id="manager-worknum" class="form-control" name="manager-worknum" value="<?= $user['worknum'] ?>">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="manager-name">姓名</label>
                <input type="text" id="manager-name" class="form-control" name="manager-name" value="<?= $user['name'] ?>">
            </div>
        <?php elseif ( $user['permission'] == User::STUDENT ): ?>
            <!-- 学生 -->
            <div class="form-group col-xs-8">
                <label class="control-label" for="student-stunum">学号</label>
                <input type="text" id="student-stunum" class="form-control" name="student-stunum" value="<?= $extra['stunum'] ?>">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="student-name">姓名</label>
                <input type="text" id="student-name" class="form-control" name="student-name" value="<?= $user['name'] ?>">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="student-grade">年级</label>
                <input type="text" id="student-grade" class="form-control" name="student-grade" value="<?= $extra['grade'] ?>">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="student-faculty">院系</label>
                <input type="text" id="student-faculty" class="form-control" name="student-faculty" value="<?= $extra['faculty'] ?>">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="student-specialty">专业</label>
                <input type="text" id="student-specialty" class="form-control" name="student-specialty" value="<?= $extra['specialty'] ?>">
            </div>
        <?php endif; ?>
            <div class="form-group col-xs-8">
                <label class="control-label" for="user-password">新密码(不填则不更新)</label>
                <input type="password" id="user-password" class="form-control" name="user-password">
            </div>
            <div class="form-group col-xs-8">
                <label class="control-label" for="user-password-again">确认密码</label>
                <input type="password" id="user-password-again" class="form-control" name="user-password-again">
            </div>

            <div class="form-group col-xs-8">
                <button class="btn btn-primary btn-block" id="update-user-data">提交修改</button>
            </div>
    </div>
</div>