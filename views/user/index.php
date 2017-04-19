<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户';
?>
<div class="box box-success">
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
                'createdAt',
                [
                    'class' => 'liumapp\library\components\ActionColumn',
                    'template' => '{view} {update} {create} {/rbac/default/roles} {/organization/assignment/index} {/position/admin-position/create} {delete}',
                    'buttons' => [
                        '/rbac/default/roles' => function ($url, $model, $key) {
                            return Html::a('角色', $url . "&title=" . $model->realName);
                        },
                        '/organization/assignment/index' => function ($url, $model, $key) {
                            return Html::a('部门', $url);
                        },
                        '/position/admin-position/create' => function ($url, $model, $key) {
                            return Html::a('职位', $url);
                        },
                    ]
                ],
            ],
        ]); ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->

