<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/9
 * Time: 14:17
 */

namespace liumapp\library\widgets\ui;



use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class ZTreeSelect extends InputWidget
{

    public $prompt = '选择分类';
    public $treeOptions=[];

    //默认显示内容
    public $defaultValue = '';

    public function run()
    {
        $id = $this->options['id'];
        $divId = $id . 'div';
        $this->treeOptions['clientOptions']['callback']=[
            'onClick'=>new JsExpression("
                function onClick(e, treeId, treeNode) {
                    $('#$id').val(treeNode.id);
                    $('#$divId').html(treeNode.name);
                }
            ")
        ];
        $content = ZTree::widget($this->treeOptions);
        $hiddenInput = $this->renderInput();
        return <<<EL
<div class="input-group">
      $hiddenInput
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">$this->prompt <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-left" role="menu">
          <li>$content</li>
        </ul>
      </div><!-- /btn-group -->
      <div id="$divId" class="form-control">$this->defaultValue</div>
    </div><!-- /input-group -->
EL;

    }

    protected function renderInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::hiddenInput($this->name, $this->value, $this->options);
        }
    }
}