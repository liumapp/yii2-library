<?php

namespace liumapp\library\models;

/**
 * This is the ActiveQuery class for [[OrganizationResource]].
 *
 * @see OrganizationResource
 */
class OrganizationResourceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrganizationResource[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrganizationResource|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
