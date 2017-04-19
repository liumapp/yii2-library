<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Item */

$this->title = Yii::t('app', 'Permission') . ' / ' . Yii::t('app', 'Update') . ' / ' . $model->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
