<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/21
 * Time: 18:14
 */

namespace liumapp\library\widgets\ui;


use liumapp\library\assets\Select1Asset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;

class Select1 extends InputWidget
{
    public $textField = null;

    public $valOptions;

    public $namOptions;

    public function init()
    {
        parent::init();
        $this->options = ArrayHelper::merge([
            'class'=>'dropdown form-control'
        ],$this->options);
        $this->valOptions = [
            'id'=>'val-'.$this->options['id']
        ];
        $this->namOptions = [
            'id'=>'nam-'.$this->options['id']
        ];
        $this->clientOptions['valId'] = $this->valOptions['id'];
        $this->clientOptions['namId'] = $this->namOptions['id'];
    }

    public function run()
    {
        Select1Asset::register($this->getView());
        $this->registerPlugin('select1');
        return Html::tag('div',$this->renderSelect(),$this->options);
    }

    public function renderSelect()
    {
        $html = '<div data-toggle="dropdown">';

        if ($this->hasModel()){
            $html .= '<span>'.Html::encode($this->model[$this->attribute]).'</span>';
            $html .= Html::activeHiddenInput($this->model,$this->attribute,$this->valOptions);
        } else {
            $html .= '<span>'.Html::encode($this->value).'</span>';
            $html .= Html::hiddenInput($this->attribute,$this->value,$this->valOptions);
        }
        if ($this->textField) {
            $html .= Html::activeHiddenInput($this->model,$this->textField,$this->namOptions);
        } else {
            $html .= Html::hiddenInput($this->textField,$this->value,$this->namOptions);
        }
        return $html . '<i class="caret"></i></div><ul class="dropdown-menu" role="menu" style="border:1px solid gray;" ></ul>';
    }
}