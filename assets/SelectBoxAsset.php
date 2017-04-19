<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 11:10
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class SelectBoxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/huluwa/common/assets/select-box/';
    public $js = ['selectBox.js'];
    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];
}