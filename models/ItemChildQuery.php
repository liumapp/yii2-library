<?php

namespace liumapp\library\models;

/**
 * This is the ActiveQuery class for [[ItemChild]].
 *
 * @see ItemChild
 */
class ItemChildQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ItemChild[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ItemChild|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
