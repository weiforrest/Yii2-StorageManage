<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StockinDetail;

/**
 * modelsStockinDetailSearch represents the model behind the search form about `app\models\StockinDetail`.
 */
class StockinDetailSearch extends StockinDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stockin_id', 'product_id', 'count'], 'integer'],
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
        $query = StockinDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('product');

        $query->andFilterWhere([
            'id' => $this->id,
            'stockin_id' => $this->stockin_id,
            'count' => $this->count,
        ]);
        $query->andFilterWhere(['like','product.name', $this->product_id]);

        return $dataProvider;
    }
}
