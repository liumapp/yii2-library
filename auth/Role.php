<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 17:23
 */

namespace liumapp\library\auth;


class Role extends \yii\rbac\Role
{
    public $title;

    public $category = 'role';

    public $belongTo = 'role';
}