<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'info', 'time'], 'safe'],
            [['unpay', 'payed', 'sum'], 'number'],
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
        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            $query->andFilterWhere(['between', 'time', $date1, $date2]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'unpay' => $this->unpay,
            'payed' => $this->payed,
            'sum' => $this->sum,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
