<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Role */

$this->title = Yii::t('app', 'Role') . ' / ' . Yii::t('app', 'Create');

?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

