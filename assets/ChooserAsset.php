<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/6
 * Time: 9:41
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class ChooserAsset extends AssetBundle
{

    public $sourcePath = "@vendor/huluwa/admin/assets/chooser";

    public $css = [
        'chooser.css'
    ];
    public $js = [
        'chooser.js'
    ];

    public $depends = [
        'liumapp\library\assets\UIAsset'
    ];
}