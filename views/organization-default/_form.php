<?php

use liumapp\library\helpers\ViewHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Organization */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <?= ViewHelper::saveButton() ?>
            <?= ViewHelper::backButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= $form->field($model, 'pid')->dropDownList($parents, [
            'prompt' => '默认根级部门',
            'encode'=>false,
            'options' => [
                $model->id => ['disabled' => true]
            ]
        ]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'power')->textInput() ?>
        <div class="form-group text-center">
            <?= ViewHelper::saveButton() ?>
            <?= ViewHelper::backButton() ?>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<?php ActiveForm::end(); ?>
