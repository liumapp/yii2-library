<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Menu */

$this->title = '菜单 / ' . $model->label;
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= ViewHelper::linkAddButton()?>
            <?= ViewHelper::linkCopyButton(['id'=>$model->id])?>
            <?= ViewHelper::linkEditButton(['id'=>$model->id])?>
            <?= ViewHelper::linkDeleteButton(['id'=>$model->id])?>
            <?= ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'enabled',
            'label',
            'icon',
            'url',
        ],
        ]) ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->