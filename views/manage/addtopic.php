<?php

use yii\helpers\Url;

$this->title = '添加题目';
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#add-one-topic').click(function(){
        var answer = '';
        answer += $('#answer-a').is(':checked') ? 'A' : '';
        answer += $('#answer-b').is(':checked') ? 'B' : '';
        answer += $('#answer-c').is(':checked') ? 'C' : '';
        answer += $('#answer-d').is(':checked') ? 'D' : '';

        if ( answer === '' || $('#subject').val() === '' )
        {
            notify( '添加的内容不能为空' );
            return false;
        }

        if ( $('#option-a').val() === '' )
        {
            notify( '请至少设置一个答案选项' );
            return false;
        }

        $.ajax({
            url: '<?= Url::to( ['api/addtopic'] ) ?>',
            type: 'post',
            data: {
                _csrf: $('#_csrf').val(),
                subject: $('#subject').val(),
                categoryid: $('#category-select').val(),
                option_a: $('#option-a').val(),
                option_b: $('#option-b').val(),
                option_c: $('#option-c').val(),
                option_d: $('#option-d').val(),
                answer: answer
            },
            dataType: 'json',
            error: function( data ) {
                notify( data );
            },
            success: function( res ) {
                notify( res.msg );
                if ( res.status )
                    setTimeout( function(){
                        window.location.href = '<?= Url::to( ['manage/topic'] ) ?>';
                    }, 2000 );
            }
        })
    });
});
</script>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'article'] ) ?>
    <div class="col-xs-10">

        <input name="_csrf" type="hidden" id="_csrf" value="<?= yii::$app->request->csrfToken ?>">

        <div class="form-group col-xs-10">
            <label class="control-label" for="subject">题目内容</label>
            <textarea class="form-control" id="subject" rows="5"></textarea>
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="category-select">题目分类</label>
            <select class="form-control" id="category-select">
                <?php foreach ( $categoryArr as $category ): ?>
                    <option value="<?= $category['categoryid'] ?>"><?= $category['categoryname'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-a">选项 A</label>
            <input class="form-control" type="text" id="option-a" value="">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-b">选项 B</label>
            <input class="form-control" type="text" id="option-b" value="">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-c">选项 C</label>
            <input class="form-control" type="text" id="option-c" value="">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-d">选项 D</label>
            <input class="form-control" type="text" id="option-d" value="">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="answer-checkbox">正确答案</label>
            <div class="checkbox">
                <label class="col-xs-3">
                    <input id="answer-a" type="checkbox" value="A"> A
                </label>
                <label class="col-xs-3">
                    <input id="answer-b" type="checkbox" value="B"> B
                </label>
                <label class="col-xs-3">
                    <input id="answer-c" type="checkbox" value="C"> C
                </label>
                <label class="col-xs-3">
                    <input id="answer-d" type="checkbox" value="D"> D
                </label>
            </div>
        </div>

        <div class="form-group col-xs-10">
            <button class="btn btn-primary btn-block" id="add-one-topic">添加</button>
        </div>

    </div>
</div>