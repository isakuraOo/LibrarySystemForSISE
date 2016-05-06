<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '考试管理';

?>
<script type="text/javascript">
function addOneExamRule() {
    var examruleHtml = '<div class="form-inline">';
    examruleHtml += '<div class="form-group"><label for="">分类&nbsp</label>';
    examruleHtml += '<select class="form-control" name="category"><option value="0">所有分类</option>';
    <?php foreach ( $categoryArr as $category ): ?>
        examruleHtml += '<option value="<?= $category['categoryid'] ?>"><?= $category['categoryname'] ?></option>';
    <?php endforeach; ?>
    examruleHtml += '</select></div>';
    examruleHtml += '<div class="form-group"><label for="">&nbsp题数&nbsp</label><input type="text" class="form-control" name="num" placeholder="该分类考多少题"></div>';
    examruleHtml += '<div class="form-group"><label for="">&nbsp分值&nbsp</label><input type="text" class="form-control" name="scores" placeholder="每题多少分"></div></div><br>';

    $('#exam-rule').append( examruleHtml );
};

$(document).ready(function(){
    $('#update-examrule-data').click(function(){
        var category = $('select[name=category]');
        var num = $('input[name=num]');
        var scores = $('input[name=scores]');
        var examrule = { topicCount: $('#topic-count').val(), categoryTopic: {} };
        for ( i = 0; i < $('#exam-rule').children().length / 2; i++ ) {
            examrule.categoryTopic[i] = {
                id: $('select[name=category]')[i].value,
                num: $('input[name=num]')[i].value,
                scores: $('input[name=scores]')[i].value
            };
        }

        $.ajax({
            url: '<?= Url::to( ['api/updateexamrule'] ) ?>',
            type: 'post',
            data: {
                _csrf: $('input[name=_csrf]').val(),
                examrule: examrule
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
        })
    })
})
</script>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'exam'] ) ?>
    <div class="col-xs-10">
    
        <input name="_csrf" type="hidden" id="_csrf" value="<?= yii::$app->request->csrfToken ?>">

        <div class="form-group">
            <label class="control-label" for="topic-count">总题数</label>
            <input type="text" id="topic-count" class="form-control" name="topic-count" value="<?= $examrule['topicCount'] ?>">
        </div><br>

        <div id="exam-rule">
            <?php foreach ( $examrule['categoryTopic'] as $rule ): ?>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="">分类</label>
                        <select class="form-control" name="category">
                            <option value="0" <?php if ( $rule['id'] == 0 ) echo 'selected="selected"'; ?>>所有分类</option>
                            <?php foreach ( $categoryArr as $category ): ?>
                                <option value="<?= $category['categoryid'] ?>" <?php if ( $rule['id'] == $category['categoryid'] ) echo 'selected="selected"'; ?>><?= $category['categoryname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">题数</label>
                        <input type="text" class="form-control" name="num" placeholder="该分类考多少题" value="<?= $rule['num'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">分值</label>
                        <input type="text" class="form-control" name="scores" placeholder="每题多少分" value="<?= $rule['scores'] ?>">
                    </div>
                </div><br>
            <?php endforeach; ?>
        </div>

        <div class="input-group">
            <h5 style="height: 14px;"><a onclick="addOneExamRule()"><span class="glyphicon glyphicon-plus-sign"></span></a> <?= '添加一条规则' ?></h5>
        </div><br>

        <button class="btn btn-primary" type="button" id="update-examrule-data">提交修改</button>

    </div>
</div>