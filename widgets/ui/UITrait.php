<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/20 0020
 * Time: 上午 9:23
 */

namespace liumapp\library\widgets\ui;

//<div class="input-group date">
//  <div class="input-group-addon">
//    <i class="fa fa-calendar"></i>
//  </div>
//  <input type="text" class="form-control pull-right" id="datepicker">
//</div>

use yii\bootstrap\Html;

trait UITrait
{

    public $wrapperAddon = false;

    public $addonIcon = 'calendar';

    /**
     * @var string
     * [textInput,passwordInput,fileInput,
     * textarea,checkbox,radio,booleanInput,
     * dropDownList,listBox,checkboxList,radioList,listInput]
     */
    public $inputType='textInput';

    /**
     * @var array dropDownList,listBox,checkboxList,radioList,listInput
     */
    public $items = [];

    /**
     * @param $content string
     * @return string
     */
    protected function wrapperGroupAddon($content)
    {
        return <<<ELEMENT
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-{$this->addonIcon}"></i>
        </div>
        {$content}
    </div>
ELEMENT;
    }

    /**
     * 渲染输入框
     * @return mixed
     */
    protected function renderInput()
    {
        $this->options = array_merge(['class' => 'form-control'],$this->options);
        $types = [
            'listInput',
            'listBox',
            'dropDownList',
            'checkBoxList',
            'radioList',
        ];
        if (in_array($this->inputType,$types)){
            return $this->renderListInput();
        }
        return $this->renderSingleInput();
    }

    protected function renderSingleInput()
    {
        if ($this->hasModel()) {
            $inputType = 'active'.ucfirst($this->inputType);
            return Html::$inputType($this->model, $this->attribute, $this->options);
        } else {
            $inputType = $this->inputType;
            return Html::$inputType($this->name, $this->value, $this->options);
        }
    }


    protected function renderListInput()
    {
        if ($this->hasModel()) {
            $inputType = 'active'.ucfirst($this->inputType);
            return Html::$inputType($this->model, $this->attribute,$this->items, $this->options);
        } else {
            $inputType = $this->inputType;
            return Html::$inputType($this->name, $this->value, $this->items, $this->options);
        }
    }

    protected function getLanguage()
    {
        return \Yii::$app->language;
    }

    public function run()
    {
        return $this->wrapperAddon
            ? $this->wrapperGroupAddon($this->renderInput())
            : $this->renderInput();
    }
}