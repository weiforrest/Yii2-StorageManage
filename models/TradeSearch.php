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
            [['id'], 'integer'],
            [['time', 'detailCount', 'customer_id'], 'safe'],
            [['money', 'profit'], 'number'],
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
            'sort' => [
                'defaultOrder' => [
                    'time' => SORT_DESC,
                ],
            ],
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

        if(isset($this->time) && $this->time != '') {
            $date_explode = explode(" to ", $this->time);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $date2 = date("Y-m-d", strtotime("+1 day", strtotime($date2)));
            $query->andFilterWhere(['between', 'trade.time', $date1, $date2]);
        }

        $query->joinwith('customer');
        $query->andFilterWhere([
            'id' => $this->id,
            'detailSum.detail_count' => $this->detailCount,
        ]);

        $query->andFilterWhere(['like', 'money', $this->money]);
        $query->andFilterWhere(['like', 'profit', $this->profit]);
        $query->andFilterWhere(['like', 'customer.name', $this->customer_id]);

        return $dataProvider;
    }
}
