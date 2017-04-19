<?php

use yii\helpers\Html;
use liumapp\library\widgets\TreeListView;
use liumapp\library\helpers\ViewHelper;
/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单';
?>
<?= Html::beginForm()?>
<div class="box box-success menu-index">
    <div class="box-header with-border">
        <h3 class="box-title"><?php  echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?=ViewHelper::linkAddButton()?>
            <?=ViewHelper::saveButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= TreeListView::widget([
            'dataProvider' => $dataProvider,
            'treeField' => 'label',
            'columns' => [
                'label',
                [
                    'attribute'=>'icon',
                    'content'=>function($model,$key,$index,$column){
                        return '<i class="'.$model->icon.'"></i> ' . $model->icon;
                    }
                ],
                [
                    'attribute'=>'sort',
                    'content'=>function($model,$key,$index,$column){
                        return Html::textInput('sort['.$key.']',$model->sort,[
                            'size'=>'5'
                        ]);
                    }
                ],
                'enabled',
                'url',
                ['class' => 'liumapp\library\components\ActionColumn'],
            ],
        ]); ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<?= Html::endForm() ?>

