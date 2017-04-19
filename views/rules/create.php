<?php
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Rule */

$this->title = Yii::t('app', 'Rule') . ' / ' . Yii::t('app', 'Create');

?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

