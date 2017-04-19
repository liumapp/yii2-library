<?php

use yii\helpers\Html;
use liumapp\library\widgets\TreeListView;
use yii\widgets\ActiveForm;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\AdminOrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分配组织 / ' . $admin->userName;
?>
<div class="box box-success admin-organization-index">
    <?php ActiveForm::begin() ?>
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= \liumapp\library\helpers\ViewHelper::saveButton() ?>
            <?= \liumapp\library\helpers\ViewHelper::backButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= TreeListView::widget([
            'tableOptions' => ['class' => 'table table-hover table-bordered'],
            'dataProvider' => $dataProvider,
            'treeField' => 'name',
            'columns' => [
                'name',
                [
                    'class' => CheckboxColumn::className(),
                    'name' => 'organizationId',
                    'checkboxOptions' => function ($model, $key, $index, $column) use ($hasOrganizationIds) {
                        return [
                            'value' => $key,
                            'checked' => in_array($key, $hasOrganizationIds)
                        ];
                    }
                ],
            ],
        ]); ?>
    </div><!-- /.box-body -->
    <?php ActiveForm::end() ?>
<?php
$js = new \yii\web\JsExpression("
    $('.grid-view table tr').on('click',function(){
        var checkbox = $(this).find('input[type=\"checkbox\"]');
        var v = checkbox.prop('checked');
       checkbox.prop('checked',!v);
    })
");
$this->registerJs($js);
?>
</div><!-- /.box -->

