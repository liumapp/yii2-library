<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/28
 * Time: 22:33
 */

namespace liumapp\library\behaviors;


use yii\base\Behavior;
use yii\web\User;

class LoginBehavior extends Behavior
{
    public function events()
    {
        return  [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
            User::EVENT_AFTER_LOGOUT => 'afterLogout',
        ];
    }

    /**
     * 用户验证通过之后初始化用户信息
     * @param $event
     */
    public function afterLogin($event)
    {
        //$event->handled = true;
        //session
        $session = \Yii::$app->session;
        $session->set('userName',$event->identity->userName);
        $session->set('realName',$event->identity->realName);
    }


    /**
     * 用户退出的时候调用事件
     * @param $event
     */
    public function afterLogout($event)
    {
        //$event->handled =  true;
        //destroy session
        \Yii::$app->session->destroy();
    }
}