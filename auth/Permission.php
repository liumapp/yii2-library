<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 17:24
 */

namespace liumapp\library\auth;


class Permission extends \yii\rbac\Permission
{
    public $title;

    public $category='module';

    public $belongTo;
}