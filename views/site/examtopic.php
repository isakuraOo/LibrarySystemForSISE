<?php

use yii\helpers\Url;

$this->title = '入馆考试';
?>
<script type="text/javascript">
// $(document).ready(function(){
//     $('#submit-answer').click(function(){
//         var answer = '';
//         answer += $('#answer-a').is(':checked') ? 'A' : '';
//         answer += $('#answer-b').is(':checked') ? 'B' : '';
//         answer += $('#answer-c').is(':checked') ? 'C' : '';
//         answer += $('#answer-d').is(':checked') ? 'D' : '';

//         if ( answer === '' )
//         {
//             notify( '答案不能为空' );
//             return false;
//         }

//         $.ajax({
//             url: '<?= Url::to( ['site/exam'] ) ?>',
//             type: 'post',
//             data: {
//                 _csrf: $('#_csrf').val(),
//                 topicid: $('#topicid').val(),
//                 answer: answer
//             },
//             error: function( data ) {
//                 notify( data );
//             },
//             success: function( res ) {
//                 notify
//             }
//         })
//     });
// });
</script>
<div class="site-index">
    <?php if ( isset( $examEnd ) && $examEnd === TRUE ): ?>
        <div class="jumbotron">
            <h1>考试结束</h1>

            <p class="lead"><a href="<?= Url::to( ['site/index'] ) ?>">成绩: <?= $score ?> 分</a></p>
        </div>
    <?php else: ?>
        <form action="" method="post">
            <div class="panel panel-info">

                <input name="_csrf" type="hidden" id="_csrf" value="<?= yii::$app->request->csrfToken ?>">
                <input name="topicid" type="hidden" id="topicid" value="<?= $topic['id'] ?>">
                <input name="numnow" type="hidden" id="numnow" value="<?= $now ?>">

                <div class="panel-heading">
                    <?= sprintf( "(%d/%d) %s", $now, $count, $topic['subject'] ) ?>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="checkbox">
                            <?php if ( !empty( $topic['option_a'] ) ): ?>
                                <label class="col-xs-12">
                                    <input name="answer[]" id="answer-a" type="checkbox" value="A"> A <?= $topic['option_a'] ?>
                                </label>
                            <?php endif; ?>
                            <?php if ( !empty( $topic['option_b'] ) ): ?>
                                <label class="col-xs-12">
                                    <input name="answer[]" id="answer-b" type="checkbox" value="B"> B <?= $topic['option_b'] ?>
                                </label>
                            <?php endif; ?>
                            <?php if ( !empty( $topic['option_c'] ) ): ?>
                                <label class="col-xs-12">
                                    <input name="answer[]" id="answer-c" type="checkbox" value="C"> C <?= $topic['option_c'] ?>
                                </label>
                            <?php endif; ?>
                            <?php if ( !empty( $topic['option_d'] ) ): ?>
                                <label class="col-xs-12">
                                    <input name="answer[]" id="answer-d" type="checkbox" value="D"> D <?= $topic['option_d'] ?>
                                </label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <button class="btn btn-primary" type="submit" id="submit-answer">提交答案</button>
        </form>
    <?php endif; ?>
</div>