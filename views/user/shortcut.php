<?php

use yii\helpers\Html;
use liumapp\library\widgets\TreeListView;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\AdminMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '快捷菜单';
?>
<div class="box box-solid">
    <?php ActiveForm::begin() ?>
    <div class="box-header with-border">
        <h1 class="box-title"></h1>
        <div class="box-tools">
            <?=\liumapp\library\helpers\ViewHelper::saveButton()?>
            <?=\liumapp\library\helpers\ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= TreeListView::widget([
            'dataProvider' => $dataProvider,
            'treeField' => 'label',
            'columns' => [
                [
                    'options'=>['width'=>30],
                    'class' => CheckboxColumn::className(),
                    'name' => 'id',
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

