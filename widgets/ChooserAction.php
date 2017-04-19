<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/8
 * Time: 8:44
 */

namespace liumapp\library\widgets;


use liumapp\library\models\Admin;
use liumapp\library\helpers\ModelHelper;
use huluwa\organization\models\AdminOrganization;
use huluwa\organization\models\Organization;
use liumapp\library\auth\Role;
use yii\base\Action;
use yii\bootstrap\Html;
use yii\db\Query;

class ChooserAction extends Action
{


    public function run()
    {
        return $this->renderTree($this->organizations());
    }

    protected function organizations()
    {

            $nodes = [];
            $admins = (new Query())
                ->select('a.id,a.realName,a.userName,r.name as roleName,ao.organizationId')
                ->from([
                    'a' => Admin::tableName(),
                ])
                ->leftJoin(['ar' => AdminRole::tableName()], "a.id = ar.adminId")
                ->leftJoin(['r'=>Role::tableName()],"ar.roleId = r.id")
                ->innerJoin(['ao' => AdminOrganization::tableName()], "a.id = ao.adminId")
                ->where('a.isDel = 0 and a.status = 1 ')
                //->orderBy('r.sort desc')
                ->all();
            foreach ($admins as $admin) {
                if (Admin::super($admin['id'])) {
                    $admin['roleName'] = '超级管理员';
                }
                $nodes[$admin['organizationId']][$admin['id']] = $admin['realName'] . '(' . $admin['roleName'] . ')';
            }
            $organizations = (new Query())
                ->select('id,pid,name,ownerId')
                ->from(Organization::tableName())
                ->where(['isDel' => 0])
                ->all();

            //添加叶子节点
            foreach ($organizations as &$org) {
                if (isset($nodes[$org['id']]))
                    $org['leaves'] = $nodes[$org['id']];
                else
                    $org['leaves'] = [];
            }
            return ModelHelper::listToTree($organizations);


    }

    protected function renderTree($nodes)
    {
        $tree = "<ul>";
        foreach ($nodes as $node) {
            $checkbox = Html::checkbox('', false, [
                'class' => 'minimal tree-check',
            ]);
            $tree .= "<li class='text-success'>|- <i class='fa fa-folder-open'></i> <span class='tree-node'>{$node['name']}</span> {$checkbox}";
            if (!empty($node['leaves'])) {
                $checkboxList = Html::checkboxList('', [], $node['leaves'], [
                    'class' => 'tree-chooser text-primary ',
                    'itemOptions' => ['class' => 'minimal']
                ]);
                $tree .= "<ul><li>|- {$checkboxList}</li></ul>";
            }
            if (!empty($node['items'])) {
                $tree .= "{$this->renderTree($node['items'])}";
            }
            $tree .= "</li>";
        }
        return $tree . "</ul>";

    }
}