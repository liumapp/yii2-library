<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paramKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cate')->dropDownList(\liumapp\library\models\Setting::categories()) ?>

    <?= $form->field($model, 'inputType')->dropDownList([ 'text' => 'Text', 'radio' => 'Radio', 'checkbox' => 'Checkbox', 'textarea' => 'Textarea', 'select' => 'Select', 'richtext' => 'Richtext', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'preValue')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'prompt')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'paramValue')->textarea(['rows' => 6]) ?>

    <div class="form-group text-center">
        <?=\liumapp\library\helpers\ViewHelper::saveButton()?>
        <?=\liumapp\library\helpers\ViewHelper::backButton()?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
