<?php

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Setting */

$this->title = '添加参数';
?>
<div class="box box-success ">
    <div class="box-header with-border">
        <h3 class="box-title"><?php  echo \yii\helpers\Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= \liumapp\library\helpers\ViewHelper::backButton()?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->