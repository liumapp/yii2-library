<?php

use yii\helpers\Html;
use liumapp\library\helpers\ViewHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Roles');
?>
<div class="box box-success">
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

            [
                'class' => 'liumapp\library\components\ActionColumn',
                'template'=>'{view} {update} {copy} {/admin/admin-menu} {permission} {delete}',
                'buttons'=>[
                    'permission'=>function($url){
                        return Html::a(Yii::t('app','Permission'),$url,['data-pjax' => '0',]);
                    },
                    '/admin/admin-menu'=>function($url){
                        return Html::a(Yii::t('app','Menu'),$url,['data-pjax' => '0',]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->

