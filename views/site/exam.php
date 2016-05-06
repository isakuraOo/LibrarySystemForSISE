<?php

use yii\helpers\Url;

$this->title = '入馆考试';

?><!-- 
<script type="text/javascript">
$(document).ready(function(){
    $('#start-exam-button').click(function(){
        $.ajax({
            url: '<?= Url::to( ['site/exam'] ) ?>',
            type: 'post',
            dataType: 'json',
            error: function( data ) {
                notify( data );
            },
            success: function( res ) {
                notify( res.msg );
                if (  )
            }
        })
    })
})
</script> -->
<div class="site-index">
    <div class="jumbotron">
        <h1>准备好了么?</h1>

        <p class="lead">图书馆新生入馆考试</p><br>

        <form action="" method="post">
            <input name="_csrf" type="hidden" id="_csrf" value="<?= yii::$app->request->csrfToken ?>">
            <button class="btn btn-success" type="submit" name="start-exam-button">开始考试</button>
        </form>
    </div>
</div>