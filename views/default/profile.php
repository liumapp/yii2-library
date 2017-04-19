<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/15 0015
 * Time: 下午 4:06
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\ProfileForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = '个人信息 / ' . $model->realName;
?>
        <div class="box box-success CertType-update">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title)?></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-2"></div>
                <div class="col-md-8">

                    <table id="w0" class="table table-striped table-bordered detail-view">
                        <tbody>
                        <tr><th>部门</th></tr>
                        <?php foreach ($orgs as $org):?>
                            <tr><td><?= Html::encode($org['name'])?></td></tr>
                        <?php endforeach;?>
                        <tr><th>用户名</th></tr>
                        <tr><td><?= Html::encode($model->userName)?></td></tr>
                        </tbody>
                    </table>
                    <div class="CertType-form">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'realName')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

                        <div class="form-group text-center">
                            <?=\liumapp\library\helpers\ViewHelper::saveButton()?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->