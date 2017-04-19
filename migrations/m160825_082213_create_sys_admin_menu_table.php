<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sys_admin_menu`.
 */
class m160825_082213_create_sys_admin_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_admin_menu', [
            'id' => $this->primaryKey(9)->unsigned(),
            'roleId' => $this->string(63)->notNull(),
            'menuId' => $this->integer(9)->unsigned()->notNull(),
            'UNIQUE INDEX `role_menu_id_unique` (`roleId` ASC, `menuId` ASC)'
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_admin_menu');
    }
}
