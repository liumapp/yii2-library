<?php

use yii\helpers\Html;
use liumapp\library\helpers\ViewHelper;
/* @var $this yii\web\View */
/* @var $modules array */

$this->title = Yii::t('app', 'Permissions');
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= ViewHelper::linkAddButton() ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th>模块</th>
                <th>许可</th>
            </tr>

            <?php foreach($modules as $module) : ?>

                <tr>
                    <td><?=\yii\bootstrap\Html::a($module['node']['title'],[
                            '/rbac/permissions/view','id'=>$module['node']['name']
                        ])?></td>
                    <td>
                        <?php foreach($module['children'] as $child):?>
                            <?=\yii\bootstrap\Html::a($child['title'],[
                                '/rbac/permissions/view','id'=>$child['name']
                            ])?>
                        <?php endforeach;?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

