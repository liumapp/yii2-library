<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/12 0012
 * Time: 下午 3:22
 */

namespace liumapp\library\behaviors;


use yii\base\InvalidCallException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class CreateTimeBehavior extends AttributeBehavior
{

    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $createdAtAttribute = 'createdAt';
    /**
     * @inheritdoc˙
     *
     * In case, when the value is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute],
            ];
        }
    }
    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return date('Y-m-d H:i:s');
        }
        return parent::getValue($event);
    }
    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     * @throws InvalidCallException if owner is a new record (since version 2.0.6).
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }

}