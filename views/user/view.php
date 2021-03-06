<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use liumapp\library\helpers\ViewHelper;
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Admin */

$this->title = '用户 / ' . $model->userName;
$statusMap = \liumapp\library\models\Admin::$statusMap;
?>

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?php  echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?=ViewHelper::linkAddButton()?>
            <?=ViewHelper::linkCopyButton(['id' => $model->id])?>
            <?=ViewHelper::linkEditButton(['id' => $model->id])?>
            <?=ViewHelper::linkDeleteButton(['id' => $model->id])?>
            <?=ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'userName',
                'realName',
                'email:email',
                'telephone',
                [
                    'attribute'=>'status',
                    'value'=>isset($statusMap[$model->status])?$statusMap[$model->status]:''
                ],
                'createdAt',
                'updatedAt',
            ],
        ]) ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->