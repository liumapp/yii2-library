<?php

use yii\db\Migration;
use liumapp\library\helpers\RbacHelper;
/**
 * Handles the creation of table `rbac`.
 */
class m161228_061457_create_rbac_mock extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        RbacHelper::addPermissions([
            //name,title,category,rule_name,belong_to,description
            ['module_role','角色模块','module',null,'module_role','角色管理模块'],
            ['rbac/roles/index','列表','action',null,'module_role','角色列表'],
            ['rbac/roles/view','查看','action',null,'module_role','角色信息'],
            ['rbac/roles/create','添加','action',null,'module_role','角色新增'],
            ['rbac/roles/update','编辑','action',null,'module_role','角色编辑'],
            ['rbac/roles/copy','复制','action',null,'module_role','角色复制'],
            ['rbac/roles/delete','删除','action',null,'module_role','角色删除'],
            ['rbac/roles/permission','分配许可','action',null,'module_role','授权许可'],
            ['rbac/default/roles','分配角色','action',null,'module_role','授权角色'],


            ['module_permission','许可模块','module',null,'module_permission','许可管理模块'],
            ['rbac/permissions/index','列表','action',null,'module_permission','许可列表'],
            ['rbac/permissions/view','查看','action',null,'module_permission','许可信息'],
            ['rbac/permissions/create','添加','action',null,'module_permission','许可新增'],
            ['rbac/permissions/update','编辑','action',null,'module_permission','许可编辑'],
            ['rbac/permissions/copy','复制','action',null,'module_permission','许可复制'],
            ['rbac/permissions/delete','删除','action',null,'module_permission','许可删除'],



            ['module_rule','规则模块','module',null,'module_rule','规则管理模块'],
            ['rbac/rules/index','列表','action',null,'module_rule','规则列表'],
            ['rbac/rules/view','查看','action',null,'module_rule','规则信息'],
            ['rbac/rules/create','添加','action',null,'module_rule','规则新增'],
            ['rbac/rules/update','编辑','action',null,'module_rule','规则编辑'],
            ['rbac/rules/copy','复制','action',null,'module_rule','规则复制'],
            ['rbac/rules/delete','删除','action',null,'module_rule','规则删除'],
        ]);

        RbacHelper::addItemChildren('module_role',[
            'rbac/roles/index',
            'rbac/roles/view',
            'rbac/roles/create',
            'rbac/roles/update',
            'rbac/roles/delete',
            'rbac/roles/permission',
            'rbac/default/roles',
        ]);

        RbacHelper::addItemChildren('rbac/roles/create',[
            'rbac/roles/copy',
        ]);

        RbacHelper::addItemChildren('module_permission',[
            'rbac/permissions/index',
            'rbac/permissions/view',
            'rbac/permissions/create',
            'rbac/permissions/update',
            'rbac/permissions/delete',
        ]);

        RbacHelper::addItemChildren('rbac/permissions/create',[
            'rbac/permissions/copy',
        ]);

        RbacHelper::addItemChildren('module_rule',[
            'rbac/rules/index',
            'rbac/rules/view',
            'rbac/rules/create',
            'rbac/rules/update',
            'rbac/rules/delete',
        ]);


        RbacHelper::addItemChildren('rbac/rules/create',[
            'rbac/rules/copy',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
