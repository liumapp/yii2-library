<?php

use yii\db\Migration;

use liumapp\library\components\DbAuthManager;
use yii\base\InvalidConfigException;
/**
 * Handles the creation of table `sys_nodes`.
 */
class m161219_072942_create_rbac_init extends Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbAuthManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbAuthManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(63)->notNull()->comment('规则名称'),
            'data' => $this->text()->comment('序列化一个规则对象的实例'),
            'title' => $this->string(63)->notNull()->comment('标题描述规则'),
            'mod' => $this->string(31)->comment('所属模块'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ],$tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(63)->comment('名称'),
            'type' => $this->integer()->defaultValue(1)->comment('1：角色；2：许可'),
            'rule_name' => $this->string(63)->comment('规则名称'),
            'description' => $this->text(),
            'data' => $this->text(),
            'title' => $this->string(63)->comment('中文标题'),
            '`category` enum(\'module\',\'action\',\'filter\',\'role\') DEFAULT \'module\'',
            'belong_to' => $this->string(63)->notNull()->defaultValue('role')->comment('同一个家族的permissions'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name)'.
            ($this->isMSSQL() ? '' : ' ON DELETE SET NULL ON UPDATE CASCADE'),
        ],$tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');


        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(63)->notNull(),
            'child' => $this->string(63)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name)'.
            ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name)'.
            ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(63)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER dbo.trigger_auth_item_child
            ON dbo.{$authManager->itemTable}
            INSTEAD OF DELETE, UPDATE
            AS
            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
            BEGIN
            IF COLUMNS_UPDATED() > 0
                BEGIN
                    IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} NOCHECK CONSTRAINT FK__auth_item__child;
                        UPDATE {$authManager->itemChildTable} SET child = @new_name WHERE child = @old_name;
                    END
                UPDATE {$authManager->itemTable}
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                title = (SELECT data FROM inserted),
                category = (SELECT data FROM inserted),
                belong_to = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM dbo.{$authManager->itemChildTable} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM dbo.{$authManager->itemTable} WHERE name IN (SELECT name FROM deleted);
                    END
            END;");
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        if ($this->isMSSQL()) {
            $this->execute('DROP TRIGGER dbo.trigger_auth_item_child;');
        }

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
}
