<?php

namespace liumapp\library\models;

use Yii;
use liumapp\library\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 */
class ItemChild extends \yii\db\ActiveRecord
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
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 63],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('app', 'Parent'),
            'child' => Yii::t('app', 'Child'),
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
     * @return ItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemChildQuery(get_called_class());
    }
}
