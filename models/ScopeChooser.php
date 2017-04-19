<?php

namespace liumapp\library\models;


use huluwa\organization\models\AdminOrganization;
use huluwa\organization\models\Organization;
use huluwa\position\models\AdminPosition;
use huluwa\position\models\Position;
use yii\db\Query;

class ScopeChooser
{
    const ALL = 'all';
    const MYSELF = 'myself';
    const MY_SUBORDINATES = 'my_subordinates';
    const MY_CREATIONS = 'my_creations';
    const MY_SUB_CREATIONS = 'my_sub_creations';
    const SHARE_TO_ME = 'share_to_me';
    const MY_SHARE = 'my_share';

    public static function getUsers($key='all')
    {
        switch ($key) {
            case self::ALL:
                return self::getUserAll();
                break;
            case self::MYSELF:
                return self::getUsersOfMyself();
                break;
            case self::MY_SUBORDINATES:
                return self::getUsersOfMySubordinates();
                break;
            case self::MY_CREATIONS:
                return self::getUsersOfMyCreations();
                break;
            case self::MY_SUB_CREATIONS:
                return self::getUsersOfMySubordinates();
                break;
            case self::SHARE_TO_ME:
                return self::getUsersOfShareToMe();
                break;
            case self::MY_SHARE:
                return self::getUsersOfMyShare();
                break;
            default:
                $params = explode(':',$key);
                if (count($params)==2){
                    if($params[0]=='org') {
                        return self::getUsersOfOrg($params[1]);
                    }
                    if ($params[0]=='u'){
                        return self::getUsersOfId($params[1]);
                    }
                }

        }
    }

    protected static function getUsersOfOrg($orgId)
    {
        //获取全部部门信息
        $organizations = Organization::getAllOrganizations();
        //获取子部门的集合
        $results = [];
        Organization::findChildren($orgId,$organizations,$results);
        //获取子部门id的集合
        $childIds = array_keys($results);
        //组合部门id 当前部门id以及子部门id的集合
        $ids = array_merge([(int)$orgId],$childIds);
        //根据部门id 获取用户adminId的集合
        $items = (new Query())
            ->select("a.id")
            ->from(['a'=>Admin::tableName()])
            ->leftJoin(['ao'=>AdminOrganization::tableName()], "a.id=ao.adminId")
            ->leftJoin(['o'=>Organization::tableName()],"ao.organizationId = o.id and o.isDel=0")
            ->where("a.isDel=0")
            ->andWhere(['ao.organizationId'=>$ids])
            ->all();

        $adminIds = array_map('array_shift', $items);

        return $adminIds;
    }

    protected static function getUsersOfId($userId)
    {
        return [$userId];
    }

    protected static function getUserAll()
    {
        return ['all'];
    }

    protected static function getUsersOfMyself()
    {
        return [\Yii::$app->user->id];
    }

    protected static function getUsersOfMySubordinates()
    {
        $orgInfo = (new Query())
            ->select('admOrg.organizationId')
            ->from(['adm'=>Admin::tableName()])
            ->leftJoin(['admOrg'=>AdminOrganization::tableName()],'adm.id=admOrg.adminId')
            ->leftJoin(['org'=>Organization::tableName()],'org.id=admOrg.organizationId')
            ->where(['adm.id'=>\Yii::$app->user->id])
            ->orderBy('level')
            ->one();
        $powerInfo = (new Query())
            ->from(['admPs'=>AdminPosition::tableName()])
            ->leftJoin(['ps'=>Position::tableName()],'ps.id=admPs.positionId')
            ->where(['admPs.adminId'=>\Yii::$app->user->id])
            ->orderBy('power')
            ->one();
        //获取全部部门信息
        $organizations = Organization::getAllOrganizations();
        //获取子部门的集合
        $results = [];
        Organization::findChildren($orgInfo['organizationId'],$organizations,$results);
        //获取子部门id的集合
        $childIds = array_keys($results);
        //组合部门id 当前部门id以及子部门id的集合
        $ids = array_merge([(int)$orgInfo['organizationId']],$childIds);
        //根据部门id 获取用户adminId的集合
        $items = (new Query())
            ->select("a.id")
            ->from(['a'=>Admin::tableName()])
            ->leftJoin(['ao'=>AdminOrganization::tableName()], "a.id=ao.adminId")
            ->leftJoin(['o'=>Organization::tableName()],"ao.organizationId = o.id and o.isDel=0")
            ->leftJoin(['admPs'=>AdminPosition::tableName()],'admPs.adminId=a.id')
            ->leftJoin(['ps'=>Position::tableName()],'ps.id=admPs.positionId')
            ->where("a.isDel=0")
            ->andWhere(['ao.organizationId'=>$ids])
            ->andWhere(['>','ps.power',$powerInfo['power']])
            ->all();
        $adminIds = array_map('array_shift', $items);

        return array_unique($adminIds);
    }

    protected static function getUsersOfMyCreations()
    {
        return [\Yii::$app->user->id];
    }

    protected static function getUsersOfShareToMe()
    {
        return [\Yii::$app->user->id];
    }

    protected static function getUsersOfMyShare()
    {
        return [\Yii::$app->user->id];
    }
}