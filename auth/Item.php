<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 17:22
 */

namespace liumapp\library\auth;


class Item extends \yii\rbac\Item
{
    public $title;

    public $category;

    public $belongTo;
}