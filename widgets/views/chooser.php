<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 */
?>
<?= $input ?>
<?= Html::tag('div','',[
    'id'=>$id . '-tag-box',
    'class'=>'chooser-tags'
]);?>
<?php Modal::begin([
    'options'=>[
        'id'=>$id . '-modal'
    ],
    'header' => $title,
    'toggleButton' => ['label' => '选择', 'class' => 'btn btn-sm btn-success'],
    'footer'=>
        Html::button('取消',['class'=>'btn btn-sm btn-default pull-left','data-dismiss'=>'modal'])
        . Html::button('确定',['class'=>'btn btn-sm btn-primary','id'=>$id.'-save-button'])
]);

?>
    <div class="tree"></div>
<?php Modal::end() ?>
<?=Html::button('清除',['class'=>'btn btn-sm btn-primary','id'=>$id . '-reset-button'])?>