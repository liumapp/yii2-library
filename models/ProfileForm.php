<?php

namespace liumapp\library\models;


use liumapp\library\components\OSS;
use yii\base\Model;

class ProfileForm extends Model
{
    /**
     * @var string
     */
    public $realName;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $telephone;

    /**
     * @var \liumapp\library\models\Admin
     */
    public $admin;
    public $password;
    public $userName;

    
    public function rules(){
        return [
            [['realName','email','telephone','password'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'realName'=>'真实姓名',
            'email'=>'电子邮箱',
            'telephone'=>'手机',
            'password'=>'密码',
        ];
    }

    public function save(){
        $this->admin->realName = $this->realName;
        $this->admin->email = $this->email;
        $this->admin->telephone = $this->telephone;
        if ($this->password != $this->admin->password){
            $this->admin->password = $this->password;
        }
        return $this->validate()
            ? $this->admin->save(false)
            :false;
    }

    public function loadData() {
        $this->realName = $this->admin->realName;
        $this->userName = $this->admin->userName;
        $this->email = $this->admin->email;
        $this->telephone = $this->admin->telephone;
        $this->password = $this->admin->password;
        return $this;
    }

}