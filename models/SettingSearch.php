<?php

namespace liumapp\library\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the partner form about `common\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramKey','name', 'cate', 'inputType', 'preValue', 'prompt', 'paramValue'], 'safe'],
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
        $query = Setting::find();

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
        $query->andFilterWhere(['like', 'paramKey', $this->paramKey])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cate', $this->cate])
            ->andFilterWhere(['like', 'inputType', $this->inputType])
            ->andFilterWhere(['like', 'preValue', $this->preValue])
            ->andFilterWhere(['like', 'prompt', $this->prompt])
            ->andFilterWhere(['like', 'paramValue', $this->paramValue]);

        return $dataProvider;
    }
}
