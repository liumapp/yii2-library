<?php
/**
 * Created by PhpStorm.
 * User: liumapp.com@gmail.com
 * Date: 2017/1/16
 * Time: 20:58
 */

namespace liumapp\library\widgets;


use liumapp\library\assets\CaptchaAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;

class Captcha extends InputWidget
{

    public $value = 'pc';

    public $captchaId = 'geetest';

    public function run()
    {
        $this->clientOptions['url'] = Url::toRoute(['/library/geetest-default']);
        $this->clientOptions['type'] = $this->value;

        /**
         * 还需要增加一个隐藏hidden input
         */
        CaptchaAsset::register($this->getView());
        $this->registerPlugin('geetest');
        $input = $this->renderSingleInput();
        return Html::tag('div',$input .
            '<div class="gt-container"></div>
            <p class="gt-wait hide">正在加载验证码......</p>
            <p class="gt-notice hide">请先拖动验证码到相应位置</p>',$this->options);
    }

    protected function renderSingleInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute,['value'=>$this->value,'id'=>$this->captchaId]);
        } else {
            return Html::hiddenInput($this->name, $this->value,['id'=>$this->captchaId]);
        }
    }
}



