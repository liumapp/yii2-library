<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Setting */

$this->title = '参数 / ' . $model->name;
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= \liumapp\library\helpers\ViewHelper::linkAddButton()?>
            <?= \liumapp\library\helpers\ViewHelper::linkEditButton(['id' => $model->paramKey])?>
            <?= \liumapp\library\helpers\ViewHelper::linkDeleteButton(['id' => $model->paramKey])?>
            <?= \liumapp\library\helpers\ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                'name',
                'paramKey',
                'cate',
                'inputType',
                'preValue',
                'prompt',
                'paramValue:ntext',
            ],
        ]) ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->