<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \liumapp\library\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>HLW</b>CRM</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <p>请输入您的新密码：</p>

        <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->label(false)->passwordInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= \liumapp\library\helpers\ViewHelper::saveButton()?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->