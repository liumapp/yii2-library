<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Role */

$this->title = Yii::t('app', 'Role') . ' / ' . Yii::t('app', 'Update') . ' / ' . $model->name;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
