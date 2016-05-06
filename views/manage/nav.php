<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="col-xs-2 text-center">
    <ul class="nav nav-pills nav-stacked">
        <li <?php if ( $option === 'default' ): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::to( ['manage/index'] ) ?>">用户管理</a>
        </li>
        <li <?php if ( $option === 'info' ): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::to( ['manage/graphinfo'] ) ?>">信息统计</a>
        </li>
        <li <?php if ( $option === 'topic' ): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::to( ['manage/topic'] ) ?>">题库管理</a>
        </li>
        <li <?php if ( $option === 'exam' ): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::to( ['manage/exam'] ) ?>">考试设置</a>
        </li>
        <li <?php if ( $option === 'article' ): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::to( ['manage/article'] ) ?>">文章编辑</a>
        </li>
        <?php if ( yii::$app->user->identity->permission === 1 ): ?>
            <li <?php if ( $option === 'adduser' ): ?>class="active"<?php endif; ?>>
                <a href="<?= Url::to( ['manage/adduser'] ) ?>">添加用户</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>