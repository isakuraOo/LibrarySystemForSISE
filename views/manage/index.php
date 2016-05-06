<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '后台管理';
?>

<div class="row">
    <?= $this->render( 'nav', ['option' => 'default'] ) ?>
    <div class="col-xs-10">
                
        <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#manager" aria-controls="manager" role="tab" data-toggle="tab">管理员</a></li>
            <li role="presentation"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">学生</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="manager">
                <table class="table table-striped">
                    <th>工号</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>岗位</th>
                    <th>操作</th>
                    <?php foreach ( $managerArr as $manager ): ?>
                        <tr>
                            <td><?= $manager['worknum'] ?></td>
                            <td><?= $manager['name'] ?></td>
                            <td>管理员</td>
                            <td><?= $manager['positionid'] == 0 ? '暂无' : '' ?></td>
                            <td>
                                <a href="<?= Url::to( ['manage/useredit', 'uid' => $manager['id']] ) ?>"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 编辑</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="student">
                <table class="table table-striped">
                    <th>学号</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>年级</th>
                    <th>院系</th>
                    <th>专业</th>
                    <th>操作</th>
                    <?php foreach ( $studentArr as $student ): ?>
                        <?php $extra = unserialize( $student['extra'] ); ?>
                        <tr>
                            <td><?= $extra['stunum'] ?></td>
                            <td><?= $student['name'] ?></td>
                            <td>学生</td>
                            <td><?= $extra['grade'] ?></td>
                            <td><?= $extra['faculty'] ?></td>
                            <td><?= $extra['specialty'] ?></td>
                            <td>
                                <a href="<?= Url::to( ['manage/useredit', 'uid' => $student['id']] ) ?>"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 编辑</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        </div>

    </div>
</div>
    