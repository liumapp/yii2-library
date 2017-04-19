<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/26
 * Time: 14:24
 */

namespace liumapp\library\components;


use liumapp\library\auth\Rule;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class RuleBehavior extends Behavior
{
    /**
     * @var \liumapp\library\models\Rule
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function beforeSave($event)
    {
        $class = '\\'.$this->owner->name;

        if (class_exists($class)) {
            $obj = new $class;
            if ($obj instanceof Rule) {
                $obj->name = $this->owner->name;
                $obj->title = $this->owner->title;
                $obj->mod = $this->owner->mod;
                $obj->description = $this->owner->description;
                $obj->createdAt = $this->owner->created_at;
                $obj->updatedAt = $this->owner->updated_at;
            }
            $this->owner->data = serialize($obj);
        }
    }
}