<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sys_admin_organiztions`.
 */
class m161227_045443_create_sys_admin_organizations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_admin_organizations', [
            'id' => $this->primaryKey()->unsigned(),
            'adminId' => $this->integer()->unsigned()->notNull()->comment('用户id'),
            'organizationId' => $this->integer()->unsigned()->notNull()->comment('组织id'),
            'major' => $this->smallInteger(1)->defaultValue(0)->comment('用户是否全职'),
            'UNIQUE INDEX `admin_organization_id_unique` (`adminId` ASC, `organizationId` ASC)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_admin_organiztions');
    }
}
