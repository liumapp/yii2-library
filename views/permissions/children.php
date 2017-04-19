<?php

use yii\helpers\Html;
use liumapp\library\widgets\ActiveForm;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Node */
/* @var $form liumapp\library\widgets\ActiveForm */
$this->title = Yii::t('app','Edit')
    . ' / ' . $model->node
    . ' / ' . Yii::t('app','Child');

$children = $model->findChildNodesWithoutSelf();

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
            <?= $form->field($model,'child')->checkboxList($children)?>

            <div class="form-group text-center">
                <?= ViewHelper::saveButton() ?>
                <?= ViewHelper::backButton() ?>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
<?php ActiveForm::end(); ?>