<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Good;

/**
 * GoodSearch represents the model behind the search form about `app\models\Good`.
 */
class GoodSearch extends Good
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'num'], 'integer'],
            [['name', 'unit'], 'safe'],
            [['price', 'cost'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Good::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'cost' => $this->cost,
            'num' => $this->num,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }
}
