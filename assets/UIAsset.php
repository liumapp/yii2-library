<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 上午 8:16
 */
namespace liumapp\library\assets;
use yii\web\AssetBundle;
class UIAsset extends AssetBundle
{
    /**
     * 发布的css文件
     * @var array
     */
    public $css = [
        'css/hlw-ui.css',
    ];

    /**
     * 要发布的js文件
     * @var array
     */
    public $js = [
        'js/app.js','js/reminder.js'
    ];

    /**
     * 依赖的其他的assets
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'liumapp\library\assets\FontAwesomeAsset',
    ];


    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     */
    public $skin = '_all-skins';

    public $publishOptions = [
        'forceCopy'=>true,
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = dirname(__FILE__)."/hlw-ui";
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new \Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.css', $this->skin);
        }

        parent::init();
    }
}