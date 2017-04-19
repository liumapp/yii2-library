<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Rule */

$this->title = Yii::t('app', 'Rule') . ' / ' . $model->name;
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?=ViewHelper::linkAddButton()?>
            <?=ViewHelper::linkCopyButton(['id' => $model->name])?>
            <?=ViewHelper::linkEditButton(['id' => $model->name])?>
            <?=ViewHelper::linkDeleteButton(['id' => $model->name])?>
            <?=ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'title',
            'mod',
            'description',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->