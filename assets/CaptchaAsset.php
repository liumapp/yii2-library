<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/1/16
 * Time: 20:59
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class CaptchaAsset extends AssetBundle
{
    public $sourcePath="@vendor/huluwa/geetest/assets/geetest/";
    public $js=['geetest.js'];
    public $depends = [
        'liumapp\library\assets\GeeTestAsset'
    ];
}