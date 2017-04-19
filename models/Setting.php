<?php

namespace liumapp\library\models;

use liumapp\library\helpers\ModelHelper;
use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $paramKey
 * @property string $name
 * @property string $cate
 * @property string $inputType
 * @property string $preValue
 * @property string $prompt
 * @property string $paramValue
 * @property integer $sort
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramKey'], 'required'],
            [['sort'], 'integer'],
            [['inputType', 'paramValue'], 'string'],
            [['paramKey', 'cate','name'], 'string', 'max' => 32],
            [['prompt', 'preValue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paramKey' => '参数',
            'name' => '名称',
            'cate' => '分类',
            'inputType' => '输入类型',
            'paramValue' => '参数值',
            'preValue' => '预设值',
            'prompt' => '提示',
            'sort' => '排序',
        ];
    }

    /**
     * @inheritdoc
     * @return SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
    }

    /**
     * 参数分类
     * @return array
     */
    public static function categories() {
        if ($setting = self::findOne(['paramKey'=>'cate'])) {
            return ModelHelper::str2map($setting->paramValue);
        } else {
            return [];
        }
    }
}
