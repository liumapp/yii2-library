<?php

namespace liumapp\library\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property integer $user_id
 * @property string $item_name
 * @property integer $created_at
 */
class Assignment extends \yii\db\ActiveRecord
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
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_name'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 63],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'item_name' => Yii::t('app', 'Item Name'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }


    /**
     * @inheritdoc
     * @return AssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssignmentQuery(get_called_class());
    }

}
