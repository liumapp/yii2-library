<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Menu */

$this->title = '菜单 / 更新 ' . $model->label;
?>
<?= $this->render('_form', [
'model' => $model,
    'parents'=>$parents
]) ?>