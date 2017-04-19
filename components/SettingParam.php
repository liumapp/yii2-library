<?php
/**
 * Created by PhpStorm.
 * User: liumapp
 * Date: 2016/7/29 0029
 * Time: 上午 10:33
 */

namespace liumapp\library\components;


use liumapp\library\models\Setting;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class SettingParam extends Component
{

    public static $params;

    public function init()
    {
         if(empty(self::$params)) {
             $cache = \Yii::$app->cache->get($this->className());
             if (empty($cache)) {
                 $cache = ArrayHelper::map(Setting::find()->asArray()->all(),'paramKey','paramValue');
                 \Yii::$app->cache->set($this->className(),$cache);
             }
             self::$params = $cache;
         }
    }

    public function get($key) {
        if (isset(self::$params[$key]))
            return self::$params[$key];
        return '';
    }
}