<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文章管理';

?>
<script>
$(document).ready(function(){
    $('#update-index-notify').click(function(){
        $.ajax({
            url: '<?= Url::to( ['api/saveindexnotify'] ) ?>',
            type: 'post',
            data: { _csrf: $('input[name=_csrf]').val(), notify: $('#index-notify').val() },
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
    $('#article-submit').click(function(){
        $.ajax({
            url: '<?= Url::to( ['api/savearticle'] ) ?>',
            type: 'post',
            data: { _csrf: $('input[name=_csrf]').val(), title: $('#article-title').val(), content: $('#article-content').val() },
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
            },
        });
    });
})
</script>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'article'] ) ?>
    <div class="col-xs-10">
    
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <!-- 跑马灯 -->
        <div class="form-group">
            <label class="control-label" for="index-notify">首页公告</label>
            <div class="input-group">
                <input type="text" id="index-notify" class="form-control" name="index-notify" value="<?= $notify ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="update-index-notify">更新</button>
                </span>
            </div>
        </div>

        <!-- 考试须知 -->
        <!-- 加载编辑器的容器 -->
        <div class="form-group">
            <label for="article-title">考试须知－标题</label>
            <input type="text" class="form-control" name="article-title" id="article-title" value="<?= $title ?>">
            </div>
        <div class="form-group">
            <label for="article-content">考试须知-内容</label>
            <textarea class="form-control" name="article-content" id="article-content" cols="30" rows="20"><?= $content ?></textarea>
        </div>
        <button class="btn btn-primary" name="article-submit" id="article-submit">提交</button>

    </div>
</div>