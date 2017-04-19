<?php
/**
 * Created by PhpStorm.
 * User: liumapp
 * Date: 2017/2/24
 * Time: 10:44
 */

namespace liumapp\library\assets;
use yii\web\AssetBundle;

class PaceAsset extends AssetBundle
{
    public $theme = 'flash';

    public $color = 'green';

    public $sourcePath = "@bower/pace";

    public $js = [
        'pace.min.js'
    ];

    public function init()
    {
        $this->css = [
            'themes/' . $this->color . '/pace-theme-' . $this->theme . '.css'
        ];
    }
}