<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/9
 * Time: 20:35
 */

namespace liumapp\library\assets;


use yii\web\AssetBundle;

class RelationCountAsset extends AssetBundle
{

    public $sourcePath = '@vendor/huluwa/common/assets/relation-count';

    public $js = ['relation-count.js'];

    public $depends = ['liumapp\library\assets\UIAsset'];
}