<?php
namespace liumapp\library\controllers;


use liumapp\library\models\Admin;
use yii\console\Controller;

class CreateAdminController extends Controller
{
    public function actionIndex($realName,$username,$password,$email)
    {
        $user = new Admin();
        $user->realName = $realName;
        $user->userName = $username;
        $user->generateAuthKey();
        $user->setPassword($password);
        $user->status = Admin::STATUS_ACTIVE;
        $user->email = $email;
        if ($user->save())
        {
            echo "userName:" . $username . "\n";
            echo "password:" . $password . "\n";
            echo "      id:" . $user->id . "\n";
        } else {
            print_r($user->errors);
        }
    }
}