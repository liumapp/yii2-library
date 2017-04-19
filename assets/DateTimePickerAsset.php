<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/2
 * Time: 14:28
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $pluginName = 'DateTimePicker';

    public $sourcePath = "@bower/eonasdan-bootstrap-datepicker/build";

    public $css = [
        'css/bootstrap-datetimepicker.min.css'
    ];

    public $js = [
        'js/bootstrap-datetimepicker.js',
    ];

    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];

}