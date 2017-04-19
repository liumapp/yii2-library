<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12 0012
 * Time: 上午 10:39
 */

namespace liumapp\library\behaviors;


use liumapp\library\models\Assignment;
use yii\base\Behavior;
use yii\web\User;

class RbacLoginBehavior extends Behavior
{

    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin'
        ];
    }

    public function afterLogin($event) {
        //organizations
        $roles = Assignment::find()
            ->select('item_name')
            ->where(['user_id'=>\Yii::$app->user->id])
            ->indexBy('item_name')
            ->all(Assignment::getDb());
        \Yii::$app->session->set('roles',$roles);
    }
}