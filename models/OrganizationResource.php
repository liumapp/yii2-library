<?php

namespace liumapp\library\models;

use Yii;
use huluwa\common\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sys_organization_resources".
 *
 * @property integer $id
 * @property string $organizationId
 * @property string $resId
 * @property string $resType
 */
class OrganizationResource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_organization_resources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organizationId', 'resId', 'resType'], 'required'],
            [['organizationId', 'resId'], 'integer'],
            [['resType'], 'string', 'max' => 31],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'organizationId' => Yii::t('app', 'Organization ID'),
            'resId' => Yii::t('app', 'Res ID'),
            'resType' => Yii::t('app', 'Res Type'),
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
     * @return OrganizationResourceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganizationResourceQuery(get_called_class());
    }
}
