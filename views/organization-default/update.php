<?php

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Organization */

$this->title = '组织 / 编辑 / ' . $model->name;
?>
<?= $this->render('_form', [
    'model' => $model,
    'parents'=>$parents
]) ?>