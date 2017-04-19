<?php

namespace liumapp\library;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/20 0020
 * Time: 下午 2:12
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'liumapp\library\controllers';

    public $defaultRoleParent= 'admin';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}