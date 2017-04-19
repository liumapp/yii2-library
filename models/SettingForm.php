<?php

namespace liumapp\library\models;


use yii\base\Model;

class SettingForm extends Model
{

    public $id;

    public $value;

    public $name;


    public function rules()
    {
        return [
            [['value','name'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'value'=>'值'
        ];
    }



}