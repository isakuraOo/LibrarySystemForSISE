<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '题目编辑';
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#update-topic-data').click(function(){
        var answer = '';
        answer += $('#answer-a').is(':checked') ? 'A' : '';
        answer += $('#answer-b').is(':checked') ? 'B' : '';
        answer += $('#answer-c').is(':checked') ? 'C' : '';
        answer += $('#answer-d').is(':checked') ? 'D' : '';

        if ( answer === '' || $('#subject').val() === '' )
        {
            notify( '修改的内容不能为空' );
            return false;
        }

        $.ajax({
            url: "<?= Url::to( ['api/updatetopic'] ) ?>",
            type: 'post',
            data: {
                _csrf: $('#_csrf').val(),
                topicid: $('#topicid').val(),
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
    <?= $this->render( 'nav', ['option' => 'topic'] ) ?>
    <div class="col-xs-10">
    
        <input name="_csrf" type="hidden" id="_csrf" value="<?= yii::$app->request->csrfToken ?>">
        <input name="topicid" type="hidden" id="topicid" value="<?= $topic['id'] ?>">

        <div class="form-group col-xs-10">
            <label class="control-label" for="subject">题目内容</label>
            <textarea class="form-control" id="subject" rows="5"><?= $topic['subject'] ?></textarea>
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
            <input class="form-control" id="option-a" value="<?= $topic['option_a'] ?>">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-b">选项 B</label>
            <input class="form-control" id="option-b" value="<?= $topic['option_b'] ?>">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-c">选项 C</label>
            <input class="form-control" id="option-c" value="<?= $topic['option_c'] ?>">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="option-d">选项 D</label>
            <input class="form-control" id="option-d" value="<?= $topic['option_d'] ?>">
        </div>

        <div class="form-group col-xs-10">
            <label class="control-label" for="answer-checkbox">正确答案</label>
            <div class="checkbox">
                <label class="col-xs-3">
                    <input id="answer-a" type="checkbox" value="A" <?php if ( strpos( $topic['answer'], 'A' ) !== FALSE ): ?> checked=true<?php endif; ?>> A
                </label>
                <label class="col-xs-3">
                    <input id="answer-b" type="checkbox" value="B" <?php if ( strpos( $topic['answer'], 'B' ) !== FALSE ): ?> checked=true<?php endif; ?>> B
                </label>
                <label class="col-xs-3">
                    <input id="answer-c" type="checkbox" value="C" <?php if ( strpos( $topic['answer'], 'C' ) !== FALSE ): ?> checked=true<?php endif; ?>> C
                </label>
                <label class="col-xs-3">
                    <input id="answer-d" type="checkbox" value="D" <?php if ( strpos( $topic['answer'], 'D' ) !== FALSE ): ?> checked=true<?php endif; ?>> D
                </label>
            </div>
        </div>

        <div class="form-group col-xs-10">
            <button class="btn btn-primary btn-block" id="update-topic-data">提交修改</button>
        </div>

    </div>
</div>