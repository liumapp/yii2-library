<?php

use yii\grid\GridView;
use yii\bootstrap\Html;
/* @var $this yii\web\View */
/* @var $model liumapp\library\models\Setting */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设置';
$categories = \liumapp\library\models\Setting::categories();
?>

<?= Html::beginForm();?>
<div class="box box-success ">
    <div class="box-header">
            <ul class="nav nav-tabs">
                <?php foreach($categories as $key=>$name):?>
                <li role="presentation" class="<?php echo $key === $cate?'active':'' ?>">
                    <?= Html::a($name,['site','cate'=>$key])?>
                </li>
                <?php endforeach;?>
            </ul>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-hover dataTable'],
            'summary'=>false,
            'columns' => [
                'name:text:名称',
                'paramKey:text:变量',
                [
                    'options'=>[
                        'width'=>'80%'
                    ],
                    'attribute'=>'inputType',
                    'label'=>'值',
                    'content'=>function($model,$key,$index,$column) {
                        switch ($model['inputType'])
                        {
                            case 'text':
                                return Html::textInput('vars['.$model['paramKey'].']',$model['paramValue'],
                                    [
                                        'default'=>$model['preValue'],
                                        'class'=>'form-control'
                                    ]);
                                break;
                            case 'textarea':
                                return Html::textarea('vars['.$model['paramKey'].']',$model['paramValue'],
                                    [
                                        'default'=>$model['preValue'],
                                        'class'=>'form-control'
                                    ]);
                                break;
                            case 'checkbox':
                                return
                                    Html::hiddenInput('vars['.$model['paramKey'].']',0) .
                                    Html::checkbox('vars['.$model['paramKey'].']',$model['paramValue']==1);
                                break;
                        }
                    }
                ]
            ],
        ]); ?>
    </div>
    <div class="box-footer text-center">
        <?= \liumapp\library\helpers\ViewHelper::saveButton()?>
    </div><!-- box-footer -->
</div><!-- /.box -->
<?= Html::endForm();?>
