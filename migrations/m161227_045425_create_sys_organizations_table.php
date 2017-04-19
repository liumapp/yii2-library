<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sys_organiztions`.
 */
class m161227_045425_create_sys_organizations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_organizations',[
            'id'=>$this->primaryKey()->unsigned(),
            'pid'=>$this->integer()->unsigned()->notNull()->defaultValue(0)->comment('父id'),
            'ownerId'=>$this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所有者'),
            'power'=>$this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('权利值'),
            'level'=>$this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('层级'),
            'isDel'=>$this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除：1已删除，0可用'),
            'name'=>$this->string(64)->notNull()->comment('组织名称'),
            'createdAt'=>$this->dateTime()->notNull()->defaultValue(date('Y-m-d H:s:i' , 0))->comment('添加时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_organizations');
    }
}
