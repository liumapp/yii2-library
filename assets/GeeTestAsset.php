<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/1/17
 * Time: 8:38
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class GeeTestAsset extends AssetBundle
{
    public $baseUrl="http://static.geetest.com/static/tools/";
    public $js=['gt.js'];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}