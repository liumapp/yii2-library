<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '找回密码';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];

?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>HLW</b>CRM</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">通过用户名找回您的密码</p>
        <?php $form = ActiveForm::begin(['id' => 'email-pdback', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'userName', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('userName')]) ?>

        <?= $form
            ->field($model, 'verifyCode')
            ->label(false)
            ->widget(\liumapp\library\widgets\Captcha::className(),
                [
                    'clientOptions'=>[
                        'submitButton'=>'#submit'
                    ]
                ]) ?>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('发送邮件', ['id'=>'submit','class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>
        <br>
        <?= Html::a('返回',['default/login']);?><br>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
