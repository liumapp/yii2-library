<?php

use yii\helpers\Html;
use liumapp\library\helpers\ViewHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\RuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rules');
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= ViewHelper::linkAddButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{summary}{pager}",
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'name',
            'mod',
            'created_at:datetime',

            ['class' => 'liumapp\library\components\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->

