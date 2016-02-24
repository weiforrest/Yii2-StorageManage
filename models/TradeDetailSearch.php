<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TradeDetail;

/**
 * TradeDetailSearch represents the model behind the search form about `app\models\TradeDetail`.
 */
class TradeDetailSearch extends TradeDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'trade_id', 'good_id', 'count'], 'integer'],
            [['price'], 'number'],
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
        $query = TradeDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('good');

        $query->andFilterWhere([
            'id' => $this->id,
            'trade_id' => $this->trade_id,
            'count' => $this->count,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'good.name', $this->good_id]);

        return $dataProvider;
    }
}
