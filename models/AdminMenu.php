<?php

namespace liumapp\library\models;

use Yii;

/**
 * This is the model class for table "adminmenu".
 *
 * @property integer $id
 * @property string $roleId
 * @property integer $menuId
 */
class AdminMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_admin_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roleId', 'menuId'], 'required'],
            [['roleId'], 'string'],
            [['menuId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'roleId' => 'Role ID',
            'menuId' => 'Menu ID',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminMenuQuery(get_called_class());
    }
}
