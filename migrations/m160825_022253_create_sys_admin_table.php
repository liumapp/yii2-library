<?php

use yii\db\Migration;

class m160825_022253_create_sys_admin_table extends Migration
{
    public function up()
    {
        $this->createTable('sys_admin',[
            'id'=>$this->primaryKey()->unsigned(),
            'userName'=>$this->string(24)->notNull()->unique()->comment('用户名'),
            'password'=>$this->char(60)->notNull()->defaultValue('')->comment('密码'),
            'realName'=>$this->string(32)->notNull()->defaultValue('')->comment('真实姓名'),
            'email'=>$this->string(64)->null()->unique()->comment('邮箱'),
            'telephone'=>$this->string(24)->null()->comment('电话'),
            'photo'=>$this->string(128)->null()->comment('照片'),
            'passwordResetToken'=>$this->string(64)->null()->comment('重置密码令牌'),
            'authKey'=>$this->string(32)->null()->comment('自动登陆验证密钥'),
            'isDel'=>$this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除：1已删除，0可用'),
            'status'=>$this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态：1可用，0不可用'),
            'shortcutMenu'=>$this->text()->null()->comment('保存用户的快捷菜单'),
            'createdAt'=>$this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s' , 0 ))->comment('添加时间'),
            'updatedAt'=>$this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s' , 0 ))->comment('更新时间'),
        ]);

    }

    public function down()
    {
        $this->dropTable('sys_admin');
    }

}
