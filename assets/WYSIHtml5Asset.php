<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/11 0011
 * Time: 上午 10:20
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class WYSIHtml5Asset extends AssetBundle
{
    public $pluginName = 'WYSIHtml5';

    public $sourcePath = "@bower/bootstrap3-wysihtml5-bower/dist";

    public $css = [
        'bootstrap3-wysihtml5.min.css'
    ];

    public $depends = [
        'liumapp\library\assets\UIAsset',
    ];

    public function init(){
        parent::init();
        $this->js=[
            'bootstrap3-wysihtml5.all.min.js',
            'locales/bootstrap-wysihtml5.'.\Yii::$app->language.'.js',
        ];
    }
}