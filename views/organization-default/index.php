<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '组织';
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?=Html::encode($this->title)?></h3>
        <div class="box-tools">
            <?= \huluwa\common\helpers\ViewHelper::linkAddButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= \huluwa\common\widgets\TreeListView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-hover dataTable'],
            'treeField'=>'name',
            'columns' => [
                'name',
                'ownerId',
                'power',
                ['class' => 'huluwa\common\components\ActionColumn'],
            ],
        ]);
        ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->

