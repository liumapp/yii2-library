<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/20 0020
 * Time: 上午 8:39
 */

namespace liumapp\library\widgets\ui;

use liumapp\library\assets\DatePickerAsset;
use yii\bootstrap\InputWidget;

class DatePicker extends InputWidget
{
    use UITrait;

    public function init()
    {
        parent::init();
        $this->wrapperAddon = true;
        $this->addonIcon = 'calendar';
        $this->clientOptions = array_merge([
            'autoclose'=>true,
            'language' => $this->getLanguage(),
            'format' => 'yyyy-mm-dd'
        ],$this->clientOptions);
        DatePickerAsset::register($this->getView());
        $this->registerPlugin('datepicker');
    }
}
