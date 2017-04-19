<?php

namespace liumapp\library\widgets\ui;

use liumapp\library\assets\WYSIHtml5Asset;
use yii\bootstrap\InputWidget;

class WYSIHtml5Editor extends InputWidget {

    use UITrait;

    public function init()
    {
        parent::init();
        WYSIHtml5Asset::register($this->getView());
        $this->inputType = 'textarea';
        $style = 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;';
        $this->options = array_merge([
            'class'=>'textarea',
            'style'=>$style,
            'placeholder'=>'Place some text here',
        ],$this->options);
        $this->clientOptions['locale']= \Yii::$app->language;
        $this->registerPlugin('wysihtml5');
    }
}
