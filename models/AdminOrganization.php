<?php

namespace liumapp\library\models;

use liumapp\library\models\Admin;
use Yii;
use liumapp\library\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_admin_organizations".
 *
 * @property string $id
 * @property string $adminId
 * @property string $organizationId
 * @property integer $major
 */
class AdminOrganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_admin_organizations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adminId', 'organizationId'], 'required'],
            [['adminId', 'organizationId', 'major'], 'integer'],
            [['adminId', 'organizationId'], 'unique', 'targetAttribute' => ['adminId', 'organizationId'], 'message' => 'The combination of Admin ID and Organization ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'adminId' => Yii::t('app', 'Admin ID'),
            'organizationId' => Yii::t('app', 'Organization ID'),
            'major' => Yii::t('app', 'Major'),
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
     * @return AdminOrganizationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminOrganizationQuery(get_called_class());
    }

    /**
     * @param $id
     * @return int
     * @decription 获得部门在职人数
     */
    public static function getStaffTotal($id)
    {
        $count = 0;
        if ($id){
            $count = self::find()
                ->from(['admOrg'=>self::tableName()])
                ->where(['organizationId'=>$id,'isDel'=>0,'status'=>1])
                ->andWhere(['>','adm.id',1])
                ->leftJoin(['adm'=>Admin::tableName()],'adm.id=admOrg.adminId')
                ->count();
        }
        return $count;
    }

    /**
     * @param $id integer 部门id
     * @return array|AdminOrganization[] 获得部门所有在职职员的id集合
     */
    public static function getStaffIds($id)
    {
        $result = [];
        if ($id){
            $result = self::find()
                ->select('adm.id')
                ->from(['admOrg'=>self::tableName()])
                ->where(['organizationId'=>$id,'isDel'=>0,'status'=>1])
                ->andWhere(['>','adm.id',1])
                ->leftJoin(['adm'=>Admin::tableName()],'adm.id=admOrg.adminId')
                ->asArray()
                ->all();
            if ($result) return ArrayHelper::getColumn($result,'id');
        }
        return $result;
    }

    /**
     * @param $id integer 部门id
     * @return array|AdminOrganization[] 获得部门所有职员(包括离职)的id集合
     */
    public static function getAllStaffIds($id)
    {
        $result = [];
        if ($id){
            $result = self::find()
                ->select('adm.id')
                ->from(['admOrg'=>self::tableName()])
                ->where(['organizationId'=>$id])
                ->andWhere(['>','adm.id',1])
                ->leftJoin(['adm'=>Admin::tableName()],'adm.id=admOrg.adminId')
                ->asArray()
                ->all();
            if ($result) return ArrayHelper::getColumn($result,'id');
        }
        return $result;
    }
}
