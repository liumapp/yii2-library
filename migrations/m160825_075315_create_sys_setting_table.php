<?php

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class m160825_075315_create_sys_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sys_setting', [
            'paramKey' => $this->string(32)->notNull()->comment('参数变量'),
            'name' => $this->string(32)->notNull()->comment('参数名称'),
            '`inputType` ENUM(\'text\', \'radio\', \'checkbox\', \'textarea\', \'select\', \'richtext\') NOT NULL DEFAULT \'text\'',
            'cate' => $this->string(32)->null()->comment('参数分类'),
            'preValue' => $this->string(255)->null()->comment('预选值'),
            'prompt' => $this->string(255)->null()->comment('提示'),
            'paramValue' => $this->text()->null()->comment('参数值'),
            'sort' => $this->smallInteger()->notNull()->defaultValue(10000)->comment('排序'),
            'PRIMARY KEY (paramKey)',
        ]);

        $rows = [
            ['cate','参数分类','textarea','base','','配置参数分类',"base:基本\nemail:邮件服务",20],
            ['app.name','应用名称','text','base','','网站名称','Huluwa Kick Start',1],
            ['app.company','企业名称','text','base','','','Huluwa',2],
            ['app.address','地址','text','base','','','hangzhou',3],
            ['app.telephone','联系电话','text','base','','','0571-88888',4],
            ['app.email','邮箱','text','base','','','admin@huluwa.cc',5],
            ['app.beian','备案编号','text','base','','','浙',6],
            ['app.baidu.code','百度统计代码','textarea','base','','','',7],
            ['app.umeng.code','友盟统计代码','textarea','base','','','',8],
            ['email.smtp.host','smtp主机','text','email','','','',9],
            ['email.smtp.port','smtp端口','text','email','','','',10],
            ['email.account','邮箱账号','text','email','','','',11],
            ['email.password','邮箱密码','text','email','','','',12],
            ['email.smtp.ssl','是否开启ssl','checkbox','email','','','',13],
        ];
        $this->batchInsert('sys_setting',['paramKey','name','inputType','cate','preValue','prompt','paramValue','sort'],$rows);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_setting');
    }
}
