<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/21
 * Time: 19:44
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class Select1Asset extends AssetBundle
{
    public $sourcePath = '@vendor/liumapp/yii2-library/assets/select1/';
    public $js = ['select1.js'];
    public $publishOptions = [
        'forceCopy'=>true
    ];
    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];
}