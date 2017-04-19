<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/28
 * Time: 22:03
 */

namespace liumapp\library\behaviors;


use liumapp\library\models\Organization;
use yii\base\Behavior;
use yii\web\User;

class OrganizationLoginBehavior extends Behavior
{

    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin'
        ];
    }

    public function afterLogin($event) {
        //organizations
        $organizations = Organization::getAdminOrganizations(\Yii::$app->user->id);
        \Yii::$app->session->set('organizations',$organizations);
    }
}