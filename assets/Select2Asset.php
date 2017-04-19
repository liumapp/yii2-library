<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/2
 * Time: 14:28
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $pluginName = 'Select2';

    public $sourcePath = "@bower/select2/dist";

    public $css = [
        'css/select2.min.css'
    ];


    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];

    public function init()
    {
        parent::init();
        $this->js = [
            'js/select2.full.min.js',
            'js/i18n/'.\Yii::$app->language.'.js'
        ];
    }
}