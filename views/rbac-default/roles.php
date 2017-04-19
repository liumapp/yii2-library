<?php

use yii\helpers\Html;
use liumapp\library\widgets\ActiveForm;
use liumapp\library\helpers\ViewHelper;
use liumapp\library\models\Node;

/* @var $this yii\web\View */
/* @var $model \liumapp\library\models\AssignForm */
/* @var $form liumapp\library\widgets\ActiveForm */
/* @var $assignedRoles array */
/* @var $title string */
$this->title = Yii::t('app','Update')
    . ' / ' . $title
    . ' / ' . Yii::t('app','Roles');
$nodes = Node::getNodes();
$family = Node::findFamily('role',$nodes);
$members=[];
foreach($family as $member)
{
    $members[$member['name']]=$member['title'];
}

?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <?= ViewHelper::saveButton() ?>
            <?= ViewHelper::backButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model,'items')->checkboxList($members)?>
            </div>
            <div class="col-md-6">

                <?= \liumapp\library\widgets\RoleRelationChart::widget([
                    'assignedRoles'=>$model->items,
                    'options' => [
                        'id' => 'main-chart',
                        'style' => 'width: 600px;height:500px;',
                    ]
                ]) ?>
            </div>
        </div>

        <div class="form-group text-center">
            <?= ViewHelper::saveButton() ?>
            <?= ViewHelper::backButton() ?>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<?php ActiveForm::end();?>