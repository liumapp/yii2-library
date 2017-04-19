<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/8
 * Time: 14:18
 */

namespace liumapp\library\widgets\ui;


use liumapp\library\assets\Select2Asset;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;

class Select2 extends InputWidget
{

    public $url = false;

    public $data = [];

    public $prompt;

    public $params = ['type'=>'all'];

    use UITrait;

    public function init()
    {
        parent::init();
        $this->inputType='dropDownList';
        $this->options['prompt'] = $this->prompt;
        $this->options['class']= 'form-control select2';
        if ($this->url) {
            $this->clientOptions = ArrayHelper::merge([
                'ajax'=>[
                    'url'=>$this->url,
                    'dataType'=>'json',
                    'delay'=>250,
                    'cache'=>true,
                    'data'=>new JsExpression('
                        function(params){
                            return $.extend({},{
                                term: params.term
                            },'.Json::encode($this->params).');
                        }
                    '),
                    'processResults'=> new JsExpression('
                        function (data) {
                          return {
                            results:data
                          };
                        }
                    '),
                ]
            ],$this->clientOptions);
        } else {
            $this->clientOptions = ArrayHelper::merge([
                'data'=>$this->data
            ],$this->clientOptions);
        }

        Select2Asset::register($this->getView());
        //$this->getView()->registerJs('$.fn.select2.defaults.set("theme", "classic");');
        $this->registerPlugin('select2');
    }

}