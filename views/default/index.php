<?php

/* @var $this yii\web\View */
$this->title = '首页';
?>
<div class="box box-success">
    <div class="box-header">
        <div class="box-title">
            <?=\yii\helpers\Html::encode($this->title)?>
        </div>
    </div>
    <div class="box-body">
        <?php foreach($shortcuts as $cut):?>
            <div class="col-md-4">
                <div class="text-center border" style="padding: 10px;">
                    <?= \yii\bootstrap\Html::a('<i class="'.$cut['icon'].'"></i> ' . $cut['label'],'?' . $cut['url'],[
                        'class'=>'btn btn-danger'
                    ])?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="box-footer">

    </div>
</div>
