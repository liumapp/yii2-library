<?php

namespace liumapp\library\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdminOrganizationSearch represents the model behind the partner form about `backend\models\AdminOrganization`.
 */
class AdminOrganizationSearch extends AdminOrganization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'adminId', 'organizationId', 'major'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with partner query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdminOrganization::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'adminId' => $this->adminId,
            'organizationId' => $this->organizationId,
            'major' => $this->major,
        ]);

        return $dataProvider;
    }
}
