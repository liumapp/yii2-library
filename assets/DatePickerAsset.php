<?php
/**
 * Created by PhpStorm.
 * User: liumapp
 * Date: 2016/7/11 0011
 * Time: 上午 10:15
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    public $pluginName = 'DatePicker';

    public $sourcePath = "@bower/bootstrap-datepicker/dist";

    public $css = [
        'css/bootstrap-datepicker3.min.css'
    ];

    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];

    public function init()
    {
        parent::init();
        $this->js = [
            'js/bootstrap-datepicker.js',
            'locales/bootstrap-datepicker.'.\Yii::$app->language.'.min.js'
        ];
    }
}