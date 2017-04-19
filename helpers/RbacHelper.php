<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/28
 * Time: 14:24
 */

namespace liumapp\library\helpers;

use liumapp\library\models\ItemChild;
use liumapp\library\models\Node;
use liumapp\library\models\Rule;
use liumapp\library\auth\Rule as AuthRule;
use yii\base\InvalidParamException;
use yii\bootstrap\Html;
use yii\rbac\Item;

class RbacHelper
{
    /**
     * @param array $permissions array(name,title,category,rule_name,belong_to,description)
     */
    public static function addPermissions($permissions)
    {
        $datetime = time();
        foreach($permissions as &$permission){
            array_push($permission,Item::TYPE_PERMISSION,$datetime,$datetime);
        }
        Node::getDb()->createCommand()
            ->batchInsert(Node::tableName(),
                ['name','title','category','rule_name','belong_to'
                    ,'description','type','created_at','updated_at']
                ,$permissions)
            ->execute();
    }

    public static function addItemChildren($parent,$children)
    {
        $itemChildren = [];
        foreach($children as $child){
            $itemChildren[] = [$parent,$child];
        }
        ItemChild::getDb()->createCommand()
            ->batchInsert(ItemChild::tableName(),['parent','child'],$itemChildren)
            ->execute();
    }

    /**
     * @param array $rules array(name,title,mod,description)
     */
    public static function addRules($rules)
    {
        $datetime = time();
        foreach($rules as &$rule){
            $class = $rule[0];
            if (class_exists($class)) {
                $obj = new $class;
                if ($obj instanceof AuthRule){
                    $obj->name = $rule[0];
                    $obj->title = $rule[1];
                    $obj->mod = $rule[2];
                    $obj->description = $rule[3];
                    $obj->createdAt = $datetime;
                    $obj->updatedAt = $datetime;
                }
                $data = serialize($obj);
                array_push($rule,$data,$datetime,$datetime);
            }
        }
        Rule::getDb()->createCommand()
            ->batchInsert(Rule::tableName(),
                ['name','title','mod','description','data','created_at','updated_at']
                ,$rules)
            ->execute();
    }

    public static $userRoutes;
    public static function getAllRoutes()
    {
        if (empty(self::$userRoutes)) {
            self::$userRoutes = Node::getRoutesOfUser(\Yii::$app->user->id);
        }
        return self::$userRoutes;
    }

    /**
     * 检查路由的权限
     * @param $name
     * @return bool
     */
    public static function checkAccess($name)
    {
        $app = \Yii::$app;
        if (isset($app->params['superAdminId']) &&
            $app->params['superAdminId'] == $app->user->id
        ) {
            return true;
        }
        //return \Yii::$app->user->can(self::normalizeRoute($name));
        $routes = self::getAllRoutes();
        $route = self::normalizeRoute($name);
        return isset($routes[$route]);
    }

    /**
     * 格式化路由
     * @param $route
     * @return string
     */
    public static function normalizeRoute($route)
    {
        $route = \Yii::getAlias((string) $route);
        if (strncmp($route, '/', 1) === 0) {
            // absolute route
            return ltrim($route, '/');
        }

        // relative route
        if (\Yii::$app->controller === null) {
            throw new InvalidParamException("Unable to resolve the relative route: $route. No active controller is available.");
        }

        if (strpos($route, '/') === false) {
            // empty or an action ID
            return $route === '' ? \Yii::$app->controller->getRoute() : \Yii::$app->controller->getUniqueId() . '/' . $route;
        } else {
            // relative to module
            return ltrim(\Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
        }
    }

    /**
     * 权限检查的链接 a 便签url
     * 不支持
     * @param $text
     * @param $route
     * @param $params
     * @param $options
     * @param $hidden bool  false
     * @return string
     */
    public static function link($text,$route,$params=[],$options=[],$hidden=false)
    {
        if(self::checkAccess($route)) {
            array_unshift($params,$route);
            return Html::a($text,$params,$options);
        }
        return $hidden?'':$text;
    }

    /**
     * 按钮
     * @param $text
     * @param $route
     * @param $params
     * @param $flag
     * @param array $options
     * @return string
     */
    public static function linkButton($text,$route,$params,$flag,$options=[])
    {
        return self::link($text,$route,$params,array_merge([
            'class'=>'btn btn-sm btn-'.$flag
        ],$options),true);
    }

    /**
     * 添加按钮
     * @param array $params
     * @return string
     */
    public static function linkAddButton($params=[])
    {
        return self::linkButton('<i class="fa fa-plus"></i> 添加','create',$params,'success');
    }

    /**
     * 复制按钮
     * @param array $params
     * @return string
     */
    public static function linkCopyButton($params=[])
    {
        return self::linkButton('<i class="fa fa-copy"></i> 复制','copy',$params,'info');
    }

    /**
     * 批量添加按钮
     * @param array $params
     * @return string
     */
    public static function linkBatchAddButton($params=[])
    {
        return self::linkButton('<i class="fa fa-plus"></i> <i class="fa fa-plus"></i> 批量添加','batch-create',$params,'primary');
    }

    /**
     * 编辑按钮
     * @param array $params
     * @return string
     */
    public static function linkEditButton($params=[])
    {
        return self::linkButton('<i class="fa fa-edit"></i> 编辑','update',$params,'primary');
    }

    /**
     * 删除按钮
     * @param array $params
     * @return string
     */
    public static function linkDeleteButton($params=[])
    {
        return self::linkButton('<i class="fa fa-trash"></i> 删除','delete',$params,'danger',['data' => [
            'confirm' => '确定要删除吗?',
            'method' => 'post',
        ]]);
    }

    /**
     * 表单保存按钮
     * @param string $text
     * @return string
     */
    public static function saveButton($text='保存')
    {
        return Html::submitButton('<i class="fa fa-save"></i> '.$text,['class'=>'btn btn-sm btn-primary']);
    }

    /**
     * 返回按钮
     * @return string
     */
    public static function backButton()
    {
        $backUrl = \Yii::$app->session->get('back-url');
        return Html::a('<i class="fa fa-arrow-left"></i> 返回',$backUrl?$backUrl:'javascript:history.back(1);',[
            'class'=>'btn btn-sm btn-warning'
        ]);
    }

}