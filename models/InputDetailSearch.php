<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InputDetail;

/**
 * InputDetailSearch represents the model behind the search form about `app\models\InputDetail`.
 */
class InputDetailSearch extends InputDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_id', 'count'], 'integer'],
			[['good_id'], 'safe'],
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
    public function search($params, $id)
    {
        $query = InputDetail::find()->where(['input_id' => $id]);

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
            'input_id' => $this->input_id,
            'count' => $this->count,
        ]);
		$query->andFilterWhere(['like','good.name', $this->good_id]);

        return $dataProvider;
    }
}
