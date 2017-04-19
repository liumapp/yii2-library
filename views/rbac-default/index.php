<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= \liumapp\library\helpers\ViewHelper::linkAddButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}{pager}",
            'columns' => [
                'userName',
                'realName',
                'email',
                'telephone',
                'status',
                [
                    'class' => 'liumapp\library\components\ActionColumn',
                    'template' => '{view} {update} {create} {/rbac/default/roles} {/rbac/default/permissions} {delete}',
                    'buttons' => [
                        '/rbac/default/roles' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app', 'Role'), $url);
                        },
                        '/rbac/default/permissions  ' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app', 'Permission'), $url);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->

