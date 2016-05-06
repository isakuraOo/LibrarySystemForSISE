<?php

use yii\helpers\Html;

$this->title = '统计信息';
echo Html::jsFile( '@web/js/echarts.min.js' );
?>
<div class="row">
    <?= $this->render( 'nav', ['option' => 'info'] ) ?>
    <div class="col-xs-10">
        <!-- 你想做的数据统计展示 -->
    </div>
</div>