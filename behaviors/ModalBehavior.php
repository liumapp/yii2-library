<?php
/**
 * Created by PhpStorm.
 * User: liumapp
 * Date: 2017/2/24
 * Time: 9:06
 */

namespace liumapp\library\behaviors;

use yii\base\Behavior;
use yii\base\Controller;

class ModalBehavior extends Behavior
{

    public $owner;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if (\Yii::$app->request->isAjax){
            $this->owner->layout = false;
        }
    }
}