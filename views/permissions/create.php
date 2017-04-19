<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Permission */

$this->title = Yii::t('app', 'Permission') . ' / ' . Yii::t('app', 'Create');

?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

