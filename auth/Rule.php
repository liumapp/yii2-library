<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 17:27
 */

namespace liumapp\library\auth;


abstract class Rule extends \yii\rbac\Rule
{
    public $title;
    public $mod;
    public $description;
}