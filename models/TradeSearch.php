<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Trade;
use app\models\TradeDetail;

/**
 * TradeSearch represents the model behind the search form about `app\models\Trade`.
 */
class TradeSearch extends Trade
{
    public $detailCount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id'], 'integer'],
            [['time', 'done', 'detailCount'], 'safe'],
            [['money'], 'number'],
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
        $query = Trade::find();
        $subquery = TradeDetail::find()
                    ->select('trade_id, SUM(count) as detail_count')
                    ->groupBy('trade_id');
        $query->leftJoin(['detailSum' => $subquery], 'detailSum.trade_id = id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*
         *set the count search
         */
        $dataProvider->sort->attributes['detailCount'] = [
            'asc' => ['detailSum.detail_count' => SORT_ASC],
            'desc' => ['detailSum.detail_count' => SORT_DESC],
            'label' => Yii::t('app', 'Count'),
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinwith('customer');
        $query->andFilterWhere([
            'id' => $this->id,
            'time' => $this->time,
            'money' => $this->money,
            'detailSum.detail_count' => $this->detailCount,
        ]);

        $query->andFilterWhere(['like', 'done', $this->done]);
        $query->andFilterWhere(['like', 'customer.name', $this->customer_id]);

        return $dataProvider;
    }
}
