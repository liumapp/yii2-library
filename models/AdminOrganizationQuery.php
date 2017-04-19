<?php

namespace liumapp\library\models;

/**
 * This is the ActiveQuery class for [[AdminOrganization]].
 *
 * @see AdminOrganization
 */
class AdminOrganizationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminOrganization[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminOrganization|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
