<?php

use yii\db\Migration;
use liumapp\library\helpers\RbacHelper;

/**
 * Handles the creation of table `admin`.
 */
class m161228_091223_create_admin_mock extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        RbacHelper::addPermissions([
            //name,title,category,rule_name,belong_to,description
            ['module_user','用户模块','module',null,'module_user','用户管理模块'],
            ['admin/user/index','列表','action',null,'module_user','用户列表'],
            ['admin/user/view','查看','action',null,'module_user','用户信息'],
            ['admin/user/create','添加','action',null,'module_user','用户新增'],
            ['admin/user/update','编辑','action',null,'module_user','用户编辑'],
            ['admin/user/delete','删除','action',null,'module_user','用户删除'],
            ['admin/user/shortcut','快捷菜单','action',null,'module_user','快捷菜单'],


            ['module_menu','菜单模块','module',null,'module_menu','菜单管理模块'],
            ['admin/menu/index','列表','action',null,'module_menu','许可列表'],
            ['admin/menu/view','查看','action',null,'module_menu','许可信息'],
            ['admin/menu/create','添加','action',null,'module_menu','许可新增'],
            ['admin/menu/update','编辑','action',null,'module_menu','许可编辑'],
            ['admin/menu/delete','删除','action',null,'module_menu','许可删除'],

        ]);

        RbacHelper::addItemChildren('module_user',[
            'admin/user/index',
            'admin/user/view',
            'admin/user/create',
            'admin/user/update',
            'admin/user/delete',
            'admin/user/shortcut',
        ]);

        RbacHelper::addItemChildren('module_menu',[
            'admin/menu/index',
            'admin/menu/view',
            'admin/menu/create',
            'admin/menu/update',
            'admin/menu/delete',
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
