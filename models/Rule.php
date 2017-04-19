<?php

namespace liumapp\library\models;

use Yii;
use liumapp\library\components\RuleBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property string $data
 * @property string $title
 * @property string $mod
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class Rule extends \yii\db\ActiveRecord
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
        return 'auth_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['data', 'description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'title'], 'string', 'max' => 63],
            [['mod'], 'string', 'max' => 31],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'data' => Yii::t('app', 'Data'),
            'title' => Yii::t('app', 'Title'),
            'mod' => Yii::t('app', 'Mod'),
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
            RuleBehavior::className(),
        ];
    }



    /**
     * @inheritdoc
     * @return RuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RuleQuery(get_called_class());
    }
}
