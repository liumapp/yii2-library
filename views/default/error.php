<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">
    <div class="row text-center">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <?= Html::img('img/403.png', ['class' => 'img-responsive']) ?>

            <?= Html::a('<i class="fa fa-arrow-left"></i> 返回首页',['/'],['class'=>'btn  btn-success','style'=>'margin-top:-25%'])?>
        </div>

    </div>

</section>
