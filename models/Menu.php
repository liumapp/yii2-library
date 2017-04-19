<?php

namespace liumapp\library\models;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $enabled
 * @property string $label
 * @property string $icon
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'enabled', 'sort'], 'integer'],
            [['label', 'icon'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'sort' => '排序',
            'enabled' => '是否可用',
            'label' => '菜单名称',
            'icon' => '菜单icon',
            'url' => 'Url',
        ];
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    /**
     * @param $adminId
     * @param $roles
     * @return MenuQuery
     */
    public static function findMenus($adminId, $roles)
    {
        //如果是超级管理员获取全部菜单
        $query = Menu::find()->where(['enabled' => 1])->orderBy('sort desc');
        if (Admin::super($adminId) === false) {
            $roleMenus = AdminMenu::find()->where(['in', 'roleId', (is_null($roles)) ? [] : $roles])->asArray()->all();
            $query->andWhere([
                'in', 'id', ArrayHelper::getColumn($roleMenus, 'menuId')
            ]);
        }
        return $query;
    }

    /**
     * 获取所有菜单
     * @param int $adminId
     * @param array $roles
     * @return array|Menu[]
     */
    public static function getMenus($adminId = 1, $roles = [0])
    {
        return self::findMenus($adminId, $roles)->asArray()->all();
    }

    public static function findActiveMenus($menus)
    {

        $menuIds = [];
        $parentId = 0;
        $thisRoute = Yii::$app->controller->getRoute();
        if (!self::findMenuIds($menus, ['/' . $thisRoute => true], $parentId, $menuIds)) {
            /* @var $authManager \liumapp\library\components\DbAuthManager */
            $authManager = \Yii::$app->authManager;
            $permissions = $authManager->getItems(Item::TYPE_PERMISSION);
            if (isset($permissions[$thisRoute])) {
                $item = $permissions[$thisRoute];
                $items = [];
                foreach ($permissions as $permission) {
                    if ($permission->belongTo == $item->belongTo) {
                        $menuItem = '/' . $permission->name;
                        $items[$menuItem] = true;
                    }
                }
                self::findMenuIds($menus, $items, $parentId, $menuIds);
            }
        }
        return $menuIds;
    }

    public static function findMenuIds($menus, $items, $parentId, &$menuIds)
    {
        $length = count($menus);
        $findActive = false;
        for ($id = 0; $id < $length; $id++) {
            redo:
            if ($findActive === false && isset($items[$menus[$id]['url']])) {
                $menuIds[] = $menus[$id]['id'];
                $findActive = true;
                $parentId = $menus[$id]['pid'];
                $id = 0;
                goto redo;
            } else if ($findActive === true && $menus[$id]['id'] == $parentId) {
                $menuIds[] = $menus[$id]['id'];
                $parentId = $menus[$id]['pid'];
                $id = 0;
                goto redo;
            }
        }
        return $findActive;
    }
}
