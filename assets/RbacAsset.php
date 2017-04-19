<?php
/**
 * Created by PhpStorm.
 * User: liumapp
 * Date: 2016/8/17 0017
 * Time: 下午 3:10
 */

namespace vint\modules\rbac\bundles;


use yii\web\AssetBundle;

class RbacAsset extends AssetBundle
{

    public $js = [
        'js/multiSelect.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init(){
        $this->sourcePath = __DIR__ . '/../assets/';
    }
}