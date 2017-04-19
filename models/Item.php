<?php

namespace liumapp\library\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property string $title
 * @property integer $type
 * @property string $data
 * @property string $category
 * @property string $belong_to
 * @property string $rule_name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class Item extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        /* @var  $authManager \liumapp\library\components\DbAuthManager */
        $authManager = \Yii::$app->authManager;
        return $authManager->db;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'data'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['data', 'category'], 'string'],
            [['name', 'title', 'belong_to', 'rule_name'], 'string', 'max' => 63],
            [['description'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'type' => Yii::t('app', 'Type'),
            'data' => Yii::t('app', 'Data'),
            'category' => Yii::t('app', 'Category'),
            'belong_to' => Yii::t('app', 'Belong To'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }
}
