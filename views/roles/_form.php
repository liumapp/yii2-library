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

                    <?= $form->field($model, 'title')
                        ->textInput(['maxlength' => true])
                        ->hint('中文名称')
                    ?>

                    <?= $form->field($model, 'name')
                        ->textInput(['maxlength' => true])
                        ->hint('英文键值')
                    ?>

                    <?= $form->field($model, 'description')
                        ->textarea(['maxlength' => true])
                        ->hint('角色描述')
                    ?>
                    <?= $form->field($model, 'parents')
                        ->checkboxList(array_merge($model->getParentArray(),$model->getUnsignedNodes()))
                        ->hint('归属')
                    ?>
                    <?php if (!$model->isNewRecord):?>
                        <?= $form->field($model, 'children')
                            ->checkboxList(array_merge($model->getChildrenArray(),$model->getUnsignedNodes()))
                            ->hint('子项')
                        ?>
                    <?php endif;?>
                </div>
                <div class="col-md-6">
                    <?= \liumapp\library\widgets\RoleRelationChart::widget([
                        'assignedRoles'=>[$model->name],
                        'options' => [
                            'id' => 'main-chart',
                            'style' => 'width: 600px;height:500px;',
                        ]
                    ]) ?>
                </div>
            </div>

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
