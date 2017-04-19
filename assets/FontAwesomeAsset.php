<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 上午 10:29
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{

    public $sourcePath="@vendor/bower/fontawesome";

    public $css = [
        'css/font-awesome.min.css'
    ];

    public $publishOptions = [
        'except'=>['/src/','/less/','/scss/']
    ];
}