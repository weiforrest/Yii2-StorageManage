<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Input;
use app\models\InputDetail;

/**
 * InputSearch represents the model behind the search form about `app\models\Input`.
 */
class InputSearch extends Input
{
    public $detailCount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['time', 'detailCount'], 'safe'],
            [['money'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Input ID'),
            'time' => Yii::t('app', 'Time'),
            'money' => Yii::t('app', 'Money'),
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
        $query = Input::find();
        $subquery = InputDetail::find()
            ->select('input_id, SUM(count) as detail_count')
            ->groupBy('input_id');
        $query->leftJoin(['detailSum' => $subquery], 'detailSum.input_id = id');

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
            $query->andFilterWhere(['between', 'time', $date1, $date2]);
            //        } else {
            //            $query->where('date_format(time, "%Y%m") = date_format(curdate(), "%Y%m")');
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'detailSum.detail_count' => $this->detailCount,
            'money' => $this->money,
        ]);

        return $dataProvider;
    }
}
