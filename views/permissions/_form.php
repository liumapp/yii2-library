<?php

use yii\helpers\Html;
use liumapp\library\widgets\ActiveForm;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Node */
/* @var $form liumapp\library\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="box box-success">
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
            <div class="row">
                <div class="col-md-6">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'belong_to')
                        ->dropDownList(\liumapp\library\models\Node::getModuleArray()) ?>

                    <?= $form->field($model, 'category')->dropDownList([
                        'module' => Yii::t('app', 'Module'),
                        'action' => Yii::t('app', 'Action'),
                        'filter' => Yii::t('app', 'Filter'),
                        'role' => Yii::t('app', 'Role')
                    ]) ?>

                    <?= $form->field($model, 'rule_name')->widget(
                        'huluwa\ui\widgets\Select1', [
                        'clientOptions' => [
                            'url' => \yii\helpers\Url::toRoute(['/rbac/rules/options']),
                        ]
                    ]) ?>

                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col-md-6">
                    <?php if (!$model->isNewRecord): ?>
                        <?=\liumapp\library\widgets\EChartsRelation::widget([
                            'selected' => [$model->name],
                            'family' => $model->getFamily(),
                            'links' => $model->familyRelation(),
                            'options' => [
                                'style' => 'width: 360px;height:360px;',
                            ]
                        ])?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!$model->isNewRecord): ?>
                <?= $form->field($model,'parents')->widget('liumapp\library\widgets\SelectBox',[
                    'sourceItems'=>$model->getUnsignedNodes(),
                    'targetItems'=>$model->getParentArray(),
                ])->hint('归属')?>

                <?= $form->field($model,'children')->widget('liumapp\library\widgets\SelectBox',[
                    'sourceItems'=>$model->getUnsignedNodes(),
                    'targetItems'=>$model->getChildrenArray(),
                ]) ->hint('子项')?>
            <?php endif; ?>

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

