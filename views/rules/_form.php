<?php

use yii\helpers\Html;
use liumapp\library\widgets\ActiveForm;
use liumapp\library\helpers\ViewHelper;
use liumapp\library\helpers\RBACHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Rule */
/* @var $form liumapp\library\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(); ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <?= ViewHelper::saveButton() ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= ViewHelper::linkCopyButton(['id' => $model->name]) ?>
                    <?= ViewHelper::linkDeleteButton(['id' => $model->name]) ?>
                <?php endif; ?>
                <?= ViewHelper::backButton() ?>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">

            <?= $form->field($model, 'mod')
                ->dropDownList(\liumapp\library\models\Node::getModuleArray())
                ->hint('所属的模块')
            ?>

            <?= $form->field($model, 'title')
                ->textInput(['maxlength' => true])
                ->hint('名词，方便记忆') ?>

            <?= $form->field($model, 'name')
                ->textInput(['maxlength' => true])
                ->hint('规则的类名，保护命名空间。如：liumapp\library\rule\OwnerPost') ?>

            <?= $form->field($model, 'description')
                ->textInput(['maxlength' => true])
                ->hint('如不标题解释不清楚，可以在这里再次说明') ?>

            <div class="form-group text-center">
                <?= ViewHelper::saveButton() ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= ViewHelper::linkCopyButton(['id' => $model->name]) ?>
                    <?= ViewHelper::linkDeleteButton(['id' => $model->name]) ?>
                <?php endif; ?>
                <?= ViewHelper::backButton() ?>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
<?php ActiveForm::end(); ?>