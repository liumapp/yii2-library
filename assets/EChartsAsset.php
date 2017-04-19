<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/20
 * Time: 17:08
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class EChartsAsset extends AssetBundle
{

    public $sourcePath = '@bower/echarts/dist';
    public $js = [
        'echarts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}