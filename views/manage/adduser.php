<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加用户';

?>
<script type="text/javascript">
$(document).ready(function(){
    $('#add-manager').click(function(){
        if ( $('#manager-username').val() === '' )
        {
            notify( '账号不能为空' );
            return false;
        }

        $.ajax({
            url: '<?= Url::to( ['api/addmanager'] ) ?>',
            type: 'post',
            data: {
                _csrf: $('#_csrf').val(),
                username: $('#manager-username').val(),
                worknum: $('#manager-worknum').val(),
                name: $('#manager-name').val()
            },
            dataType: 'json',
            error: function( data ) {
                notify( data );
            },
            success: function( res ) {
                notify( res.msg );
                if ( res.status )
                    setTimeout( function(){
                        location.reload();
                    }, 2000 );
            }
        });
    });
});
</script>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'adduser'] ) ?>
    <div class="col-xs-10">

        <h4 class="text-center">添加一位普通管理员用户</h4>
        <h5 class="text-center">新用户密码默认为: 123456</h5>
    
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <div class="form-group col-xs-8 col-xs-offset-2">
            <label class="control-label" for="manager-username">帐号</label>
            <input type="text" id="manager-username" class="form-control" name="manager-username">
        </div>
        <div class="form-group col-xs-8 col-xs-offset-2">
            <label class="control-label" for="manager-worknum">工号</label>
            <input type="text" id="manager-worknum" class="form-control" name="manager-worknum">
        </div>
        <div class="form-group col-xs-8 col-xs-offset-2">
            <label class="control-label" for="manager-name">姓名</label>
            <input type="text" id="manager-name" class="form-control" name="manager-name">
        </div>

        <div class="form-group col-xs-8 col-xs-offset-2">
            <button class="btn btn-primary btn-block" id="add-manager">提交</button>
        </div>

    </div>
</div>