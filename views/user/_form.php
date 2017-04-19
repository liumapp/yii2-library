<?php

use liumapp\library\helpers\ViewHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo \yii\helpers\Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <?= ViewHelper::saveButton() ?>
                <?= ViewHelper::backButton() ?>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= $form->field($model, 'userName')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'realName')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'status')->checkbox() ?>
            <div class="form-group text-center">
                <?= ViewHelper::saveButton() ?>
                <?= ViewHelper::backButton() ?>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
<?php ActiveForm::end(); ?>