<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m160825_080925_create_sys_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_menu', [
            'id' => $this->primaryKey(9)->unsigned(),
            'pid' => $this->integer(9)->unsigned()->notNull()->defaultValue(0),
            'enabled' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否可用'),
            'sort' => $this->smallInteger()->notNull()->defaultValue(0)->comment('排序'),
            'label' => $this->string(32)->comment('名称'),
            'icon' => $this->string(32)->comment('图标'),
            'url' => $this->string(64)->comment('地址'),
        ]);
        

        $rows = [
            [1,0,1,1,'系统','fa fa-gears','#'],
            [2,0,1,2,'管理','fa fa-wrench','#'],

            [101,1,1,1,'个人信息','fa fa-vcard','/admin/default/profile'],
            [102,1,1,2,'组织','fa fa-group','/organization/default/index'],
            [103,1,1,3,'角色','fa fa-user-o','/rbac/roles/index'],
            [104,1,1,4,'管理员','fa fa-user','/admin/user/index'],

            [105,2,1,6,'设置','fa fa-gear','/admin/setting/site'],
            [106,2,1,5,'模块','fa fa-plug','/rbac/permissions/index'],
            [107,2,1,4,'参数','fa fa-gear','/admin/setting/index'],
            [108,2,1,3,'日志','fa fa-map-pin','/log/default/index'],
            [109,2,1,2,'菜单','fa fa-bars','/admin/menu/index'],
            [110,2,1,1,'清理缓存','fa fa-trash','/admin/tool/clean-cache'],
        ];
        $this->batchInsert('sys_menu',['id','pid','enabled','sort','label','icon','url'],$rows);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_menu');
    }
}
