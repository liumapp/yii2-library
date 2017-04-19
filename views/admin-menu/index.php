<?php

use yii\helpers\Html;
use liumapp\library\widgets\TreeListView;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\AdminMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分配菜单 / ' . $role->name;
?>
<div class="box box-solid admin-menu-index">
    <?php ActiveForm::begin() ?>
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?=\liumapp\library\helpers\ViewHelper::saveButton()?>
            <?=\liumapp\library\helpers\ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= TreeListView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-hover dataTable'],
            'treeField' => 'label',
            'columns' => [
                [
                    'class' => CheckboxColumn::className(),
                    'name' => 'menuId',
                    'headerOptions'=>['width'=>'30'],
                    'checkboxOptions' => function ($model, $key, $index, $column) use ($hasMenuIds) {
                        return [
                            'value' => $key,
                            'checked' => in_array($key, $hasMenuIds)
                        ];
                    }
                ],
                'label',
                'url',
            ],
        ]); ?>
    </div><!-- /.box-body -->
    <?php ActiveForm::end() ?>
</div><!-- /.box -->

