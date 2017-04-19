<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Node */

$this->title = Yii::t('app', 'Role') . ' / ' . $model->title;
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?=ViewHelper::linkAddButton()?>
            <?=ViewHelper::linkCopyButton(['id' => $model->name])?>
            <?=ViewHelper::linkEditButton(['id' => $model->name])?>
            <?=ViewHelper::linkDeleteButton(['id' => $model->name])?>
            <?=ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php
        $parents = [];
        $nodes = $model->getFamily();
        foreach($model->parents as $parent){
            $parents[] = $nodes[$parent]['title'];
        }
        $children = [];
        foreach($model->children as $child){
            $children[] = $nodes[$child]['title'];
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'name',
                        'description',
                        [
                            'attribute'=>'parents',
                            'value'=>implode(' ',$parents)
                        ],
                        [
                            'attribute'=>'children',
                            'value'=>implode(' ',$children)
                        ]
                    ],
                ]) ?>
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
    </div><!-- /.box-body -->
</div><!-- /.box -->