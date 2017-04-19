<?php

use yii\helpers\Html;
use yii\grid\GridView;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $searchModel liumapp\library\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '参数';
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= ViewHelper::linkAddButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'=>$searchModel,
            'layout'=>"{items}\n{summary}\n{pager}",
            'columns' => [
                'name',
                'paramKey',
                [
                    'attribute' => 'cate',
                    'filter' => \liumapp\library\models\Setting::categories(),
                    'content' => function ($model, $key, $index, $column) {
                        $map = $column->filter;
                        return isset($map[$model->cate]) ? $map[$model->cate] : '';
                    }
                ],
                'inputType',
                [
                    'attribute' => 'paramValue',
                    'content' => function ($model, $key, $index, $column) {
                        if (in_array($model->inputType, ['text', 'radio', 'checkbox', 'select'])) {
                            return $model->paramValue;
                        } else {
                            return ViewHelper::link('点击查看', 'view', ['id' => $key]);
                        }
                    }
                ],
                ['class' => 'liumapp\library\components\ActionColumn'],
            ],
        ]); ?>
    </div><!-- /.box-body -->
    <!--div class="box-footer">

    </div--><!-- box-footer -->
</div><!-- /.box -->
