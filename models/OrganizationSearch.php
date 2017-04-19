<?php

namespace liumapp\library\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * OrganizationSearch represents the model behind the partner form about `backend\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'ownerId', 'power'], 'integer'],
            [['name', 'createdAt'], 'safe'],
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
        $query = Organization::find();

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
            'pid' => $this->pid,
            'ownerId' => $this->ownerId,
            'power' => $this->power,
            'createdAt' => $this->createdAt,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
