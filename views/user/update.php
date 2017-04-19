<?php

/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Admin */

$this->title = '用户 / 编辑 / ' . $model->userName;
?>
<?= $this->render('_form', [
'model' => $model,
]) ?>