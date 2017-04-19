<?php

use yii\db\Migration;
use huluwa\rbac\helpers\RbacHelper;

/**
 * Handles the creation of table `organization`.
 */
class m161228_093631_create_organization_mock extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        RbacHelper::addPermissions([
            //name,title,category,rule_name,belong_to,description
            ['module_organization','组织模块','module',null,'module_organization','组织管理模块'],
            ['organization/default/index','列表','action',null,'module_organization','组织列表'],
            ['organization/default/view','查看','action',null,'module_organization','组织信息'],
            ['organization/default/create','添加','action',null,'module_organization','组织新增'],
            ['organization/default/update','编辑','action',null,'module_organization','组织编辑'],
            ['organization/default/copy','复制','action',null,'module_organization','组织复制'],
            ['organization/default/delete','删除','action',null,'module_organization','组织删除'],
        ]);

        RbacHelper::addItemChildren('module_organization',[
            'organization/default/index',
            'organization/default/view',
            'organization/default/create',
            'organization/default/update',
            'organization/default/delete',
        ]);


        RbacHelper::addItemChildren('organization/default/create',[
            'organization/default/copy',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
