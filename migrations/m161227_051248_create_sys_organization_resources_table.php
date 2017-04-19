<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sys_organization_resources`.
 */
class m161227_051248_create_sys_organization_resources_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_organization_resources', [
            'id' => $this->primaryKey(),
            'organizationId' => $this->integer()->unsigned()->notNull()->comment('组织id'),
            'resId' => $this->bigInteger()->unsigned()->notNull()->comment('资源id'),
            'resType' => $this->string(31)->notNull()->comment('资源类型'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_organization_resources');
    }
}
