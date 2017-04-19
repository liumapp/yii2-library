<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/14
 * Time: 11:36
 */

namespace liumapp\library\widgets;

use liumapp\library\models\AdminOrganization;
use liumapp\library\models\Organization;
use huluwa\position\models\AdminPosition;
use huluwa\position\models\Position;
use Yii;
use liumapp\library\models\Admin;
use liumapp\library\models\ScopeChooser;
use yii\base\Action;
use yii\db\Query;
use yii\helpers\Json;

class ScopeChooserAction extends Action
{

    public function run($term = '', $limit = 10)
    {
        $term = Yii::$app->request->post('term');
        $currentUserId = \Yii::$app->user->id;
        //$isSuper = Admin::super($currentUserId);
        if ($term){
            $options = [];
        }else {
            $options = [
                [
                    'id' => ScopeChooser::ALL,
                    'text' => Yii::t('app', ScopeChooser::ALL)
                ],
                [
                    'id' => ScopeChooser::MYSELF,
                    'text' => Yii::t('app', ScopeChooser::MYSELF)
                ],
                [
                    'id'=>ScopeChooser::MY_SUBORDINATES,
                    'text'=>Yii::t('app',ScopeChooser::MY_SUBORDINATES)
                ],
                [
                    'id' => ScopeChooser::MY_CREATIONS,
                    'text' => Yii::t('app', ScopeChooser::MY_CREATIONS)
                ],
                [
                    'id' => ScopeChooser::MY_SUB_CREATIONS,
                    'text' => Yii::t('app', ScopeChooser::MY_SUB_CREATIONS)
                ],
            ];
        }


        $orgs = Organization::findAdminManagerOrganization($currentUserId);
//        print_r($orgs);exit;
        $organizations = Organization::subtree($orgs);

        //增加岗位权限判断 power值必须小于本人
        $powerInfo = (new Query())
            ->from(['admPs'=>AdminPosition::tableName()])
            ->leftJoin(['ps'=>Position::tableName()],'ps.id=admPs.positionId')
            ->where(['admPs.adminId'=>\Yii::$app->user->id])
            ->orderBy('power')
            ->one();
        $query = new Query();
        $items = $query
            ->select("a.id,a.userName,a.realName,ao.organizationId,o.name")
            ->from(['a' => Admin::tableName()])
            ->leftJoin(['ao' => AdminOrganization::tableName()], "a.id=ao.adminId")
            ->leftJoin(['o' => Organization::tableName()], "ao.organizationId = o.id and o.isDel=0")
            ->leftJoin(['admPs'=>AdminPosition::tableName()],'admPs.adminId=a.id')
            ->leftJoin(['ps'=>Position::tableName()],'ps.id=admPs.positionId')
            ->where("a.isDel=0")
            ->andWhere(['>','ps.power',$powerInfo['power']])
            ->andWhere(['ao.organizationId' => array_keys($orgs)])
            ->andFilterWhere(['like', 'a.realName', $term])
            ->all();
        $orgUsers = [];
        foreach ($items as $item) {
            $orgUsers[$item['organizationId']]['u:' . $item['id']]
                = $item['realName'] . '(' . $item['userName'] . ')';
        }
        if ($term){
            foreach ($organizations as $organization) {
                $orgId = $organization['id'];
                if (isset($orgUsers[$orgId]) && is_array($orgUsers[$orgId])) {
                    foreach ($orgUsers[$orgId] as $key => $child) {
                        $options[] = [
                            'id' => $key,
                            'text' => $child,
                        ];
                    }
                }
            }
        }else{
            foreach ($organizations as $organization) {
                $orgId = $organization['id'];
                $options[] = [
                    'id' => 'org:' . $orgId,
                    'text' => $organization['name'],
                    'isOrg'=>1
                ];
                if (isset($orgUsers[$orgId]) && is_array($orgUsers[$orgId])) {
                    foreach ($orgUsers[$orgId] as $key => $child) {
                        $options[] = [
                            'id' => $key,
                            'text' => $child,
                        ];
                    }
                }
            }
        }


//        $options[] = [
//            'id'=>ScopeChooser::SHARE_TO_ME,
//            'text'=>Yii::t('app',ScopeChooser::SHARE_TO_ME)
//        ];
//        $options[] = [
//            'id'=>ScopeChooser::MY_SHARE,
//            'text'=>Yii::t('app',ScopeChooser::MY_SHARE)
//        ];

        return Json::encode(['results'=>$options]);
    }

}