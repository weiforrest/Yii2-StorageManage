<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Input;

/**
 * InputSearch represents the model behind the search form about `app\models\Input`.
 */
class InputSearch extends Input
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['time'], 'safe'],
			[['count'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Input ID'),
            'time' => Yii::t('app', 'Time'),
			'count' => Yii::t('app', 'Count'),
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
		$query = Input::find()->select([
			'input.id',
			'time',
			'sum(count) as count',
		])->innerJoin('input_detail', 'input.id = input_detail.input_id')->groupBy('input_detail.input_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		/*
		 *set the count search 	
		 */
		$dataProvider->sort->attributes['count'] = [
					'asc' => ['sum(count)' => SORT_ASC],
					'desc' => ['sum(count)' => SORT_DESC],
					'label' => Yii::t('app', 'Count'),
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'input.id' => $this->id,
            'time' => $this->time,
			'count' => $this->count,
        ]);

        return $dataProvider;
    }
}
