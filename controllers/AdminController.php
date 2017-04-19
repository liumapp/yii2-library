<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/5
 * Time: 14:33
 */

namespace liumapp\library\controllers;


use liumapp\library\models\Admin;
use liumapp\library\models\AdminOrganization;
use liumapp\library\models\Organization;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionIndex($id=0)
    {
        $nodes = [];
        $admins = (new Query())
            ->select('a.id,a.realName')
            ->from(['a'=>Admin::tableName(),'ao'=>AdminOrganization::tableName()])
            ->where('a.id = ao.adminId and a.isDel = 0 and a.status = 1')
            ->andWhere(['ao.organizationId'=>$id])
            ->all();
        foreach($admins as $admin) {
            $nodes[] = [
                'id'=>$admin['id'],
                'text'=>$admin['realName'],
                'icon'=>'fa fa-user'
            ];
        }
        $organizations = Organization::findAll(['pid'=>$id,'isDel'=>0]);
        foreach($organizations as $org)
        {
            $nodes[] = [
                'id'=>$org->id,
                'text'=>$org->name,
                'icon'=> 'fa fa-folder',
                'children'=>true,
            ];
        }
        return Json::encode($nodes);
    }

}