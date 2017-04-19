<?php

namespace liumapp\library\models;

use liumapp\library\models\Admin;
use liumapp\library\helpers\ModelHelper;
use Yii;
use liumapp\library\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_organizations".
 *
 * @property string $id
 * @property string $pid
 * @property string $ownerId
 * @property integer $power
 * @property integer $isDel
 * @property string $name
 * @property string $createdAt
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_organizations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'ownerId', 'power', 'isDel'], 'integer'],
            [['name'], 'required'],
            [['createdAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'ownerId' => Yii::t('app', 'Owner ID'),
            'power' => Yii::t('app', 'Power'),
            'isDel' => Yii::t('app', 'Is Del'),
            'name' => Yii::t('app', 'Name'),
            'createdAt' => Yii::t('app', 'Created At'),
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
     * @return OrganizationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

    /**
     * 获取部门路径
     * @param $adminId
     * @return array
     */
    public static function getAdminOrganizations($adminId) {
        $ids = self::getOrganizationIdsOfAdmin($adminId);
        $organizations = (new Query())
            ->select(['id','pid', 'name'])
            ->from(self::tableName())
            ->all();
        $map = ArrayHelper::index($organizations,'id');

        $organizationPath = [];
        foreach($ids as $id) {
            $organizationPath[$id] = ModelHelper::treePath($map,$id);
        }

        return $organizationPath;
    }

    /**
     * @param $adminId
     * @return array 二位数组
     * @description 获取不重复的部门
     */
    public static function getAdminOrganizationsUnique($adminId)
    {
        $orgs = self::getAdminOrganizations($adminId);
        $result = [];
        foreach ($orgs as $items){
            foreach ($items as $org){
                if (!in_array($org,$result)) $result[] = $org;
            }
        }
        return $result;
    }

    public static function getAllOrganizations()
    {
        $items = (new Query())->from(self::tableName())
            ->where(['isDel'=>0])
            ->indexBy('id')
            ->all();

        return $items;
    }

    public static function findChildren($id,$items,&$results)
    {
        foreach($items as $key => $item) {
            if ($item['pid']==$id) {
                $results[$key] = $item;
                self::findChildren($key,$items,$results);
            }
        }
        return $results;
    }

    public static function getOrganizationIdsOfAdmin($adminId) {
        $orgIds = AdminOrganization::find()->where(['adminId'=>$adminId])->asArray()->all();
        return ArrayHelper::getColumn($orgIds,'organizationId');
    }

    public static function findAdminManagerOrganization($adminId) {
        $items = self::getAllOrganizations();
        $ids = self::getOrganizationIdsOfAdmin($adminId);
        $childIds = [];
        foreach($ids as $id) {
            $childIds[$id] = $items[$id];
            self::findChildren($id,$items,$childIds);
        }

        return $childIds;
    }

    public static function subtree($childIds)
    {
        foreach($childIds as $key => &$child){
            if (empty($childIds[$child['pid']])) {
                $child['parent'] = 0;
            }
            else {
                $child['parent'] = $child['pid'];
            }

        }
        return ModelHelper::subTree($childIds);
    }

    public static function getOrgsAdmins($orgId,$allOrgs,$allAdminOrgs,&$admins)
    {
        $subOrgs = [];
        self::findChildren($orgId,$allOrgs,$subOrgs);
        if ($subOrgs){
            foreach ($subOrgs as $org){
               self::getOrgsAdmins($org['id'],$allOrgs,$allAdminOrgs,$admins);
            }
        }
        //找出下面所属的人
        $result = self::findAdminsOfOrg($orgId,$allAdminOrgs);
        if ($result) {
            foreach ($result as $id){
                $admins[] = $id;
            }
        }
        $admins = array_unique($admins);
    }

    /**
     * @param $orgId
     * @param $allAdminOrgs
     * @return array
     * @description 找出直属于该部门的职员
     */
    public static function findAdminsOfOrg($orgId, $allAdminOrgs)
    {
        $result = [];
        foreach ($allAdminOrgs as $item){
            if ($item['organizationId'] == $orgId)
                $result[] = $item['adminId'];
        }
        return $result;
    }

    public static function getOrgAdminRelation()
    {
       $allAdminOrgs = AdminOrganization::find()
           ->select('adminId,organizationId,realName name')
           ->leftJoin(['adm'=>Admin::tableName()],'adminId=adm.id')
           ->where(['isDel'=>0,'status'=>1])
           ->asArray()
           ->all();
       $allOrgs = self::getAllOrganizations();
       $result = [];
       foreach ($allOrgs as $org){
            $tmp = [];
            $tmp['id'] = $org['id'];
            $tmp['pId'] = $org['pid'];
            $tmp['name'] = $org['name'];
            foreach ($allAdminOrgs as $adminOrg){
                if ($adminOrg['organizationId'] == $org['id']){
                    $tmpAdminOrg['id'] = 0;
                    $tmpAdminOrg['pId'] = $org['id'];
                    $tmpAdminOrg['name'] = $adminOrg['name'];
                    $tmpAdminOrg['adminId'] = $adminOrg['adminId'];
                    $result[] = $tmpAdminOrg;
                }
            }
            $result[] = $tmp;
       }
       print_r(json_encode($result)) ;
    }
}
