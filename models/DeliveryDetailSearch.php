<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeliveryDetail;

/**
 * DeliveryDetailSearch represents the model behind the search form about `app\models\DeliveryDetail`.
 */
class DeliveryDetailSearch extends DeliveryDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'delivery_id', 'product_id', 'count'], 'integer'],
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
        $query = DeliveryDetail::find();

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
            'delivery_id' => $this->delivery_id,
            'count' => $this->count,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->product_id]);

        return $dataProvider;
    }
}
