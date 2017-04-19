<?php

use yii\helpers\Html;
use liumapp\library\widgets\TreeListView;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;
use liumapp\library\helpers\ViewHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $roleAfterFirstGenerationPermission array */
/* @var $roleFirstGenerationPermissions array */
/* @var $modules array */
/* @var $role array */

$this->title = '角色分配权限 / ' . $role['name'];
?>
<div class="box box-success assignment-index">
    <?php ActiveForm::begin() ?>
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= ViewHelper::saveButton() ?>
            <?= ViewHelper::backButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php
        $items = [];
        foreach ($modules as $module) {
            $item = [
                'label' => $module['node']['title']
            ];
            $checkboxList = [];
            $checkedList = [];
            foreach ($module['family'] as $child) {
                $checked = false;
                $options = [
                    'value' => $child['name'],
                    'label' => $child['title'],
                ];
                //可以修改
                if (in_array($child['name'], $roleFirstGenerationPermissions)) {
                    $checked = true;
                    $checkedList[] = $child['name'];

                    //不可以修改
                } else if (in_array($child['name'], $roleAfterFirstGenerationPermission)) {
                    $checked = true;
                    $checkedList[] = $child['name'];
                    $options['disabled'] = true;
                }
                $checkboxList[] = Html::checkbox('name[]', $checked, $options);
            }
            $item['content'] = Html::tag('div', implode(' ', $checkboxList));
            $item['content'] .= \liumapp\library\widgets\GoRelation::widget([
                'node' => $module['node'],
                'selected'=>$checkedList,
                'family' => $module['family'],
                'links' => $module['links'],
                'options' => [
                    'style' => 'width: 300px;height:300px; background-color: #DAE4E4;',
                ]
            ]);
            $items[] = $item;
        }
        echo \yii\bootstrap\Collapse::widget([
            'items' => $items
        ]);
        ?>
    </div><!-- /.box-body -->
    <?php ActiveForm::end() ?>
</div><!-- /.box -->

