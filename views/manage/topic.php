<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '题库管理';

?>

<div class="row">
    <?= $this->render( 'nav', ['option' => 'topic'] ) ?>
    <div class="col-xs-10">

        <?php
            $form = ActiveForm::begin([
                        'id' => "topic-form",
                        'enableAjaxValidation' => false,
                        'options' => ['enctype' => 'multipart/form-data'],
            ]);
        ?>
        <div class="form-group">
            <a href="<?= Url::to( ['manage/addtopic'] ) ?>"><button class="btn btn-primary" type="button" name="add-topic" id="add-topic">添加题目</button></a>
        </div>

        <?php ActiveForm::end(); ?>

        <table class="table table-striped">
            <th class="col-xs-8">题目</th>
            <th class="col-xs-2">分类</th>
            <th class="col-xs-2">操作</th>
            <?php if ( empty( $topicArr ) ): ?>
                <tr><td colspan="3"><p class="text-center">题库中暂无资料</p></td></tr>
            <?php else: ?>
                <?php foreach( $topicArr as $topic ): ?>
                    <tr>
                        <td><?= $topic['subject'] ?></td>
                        <td><?= $topic['category']['categoryname'] ?></td>
                        <td>
                            <a href="<?= Url::to( ['manage/edittopic', 'topicid' => $topic['id']] ) ?>"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 编辑</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr align="center"><td colspan="3"><?= LinkPager::Widget( ['pagination' => $pages] ) ?></td></tr>
            <?php endif; ?>
        </table>

    </div>
</div>