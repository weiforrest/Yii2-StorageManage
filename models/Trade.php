<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "trade".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $time
 * @property string $money
 * @property string $done
 *
 * @property ReceiveMoney[] $receiveMoneys
 * @property Customer $customer
 * @property TradeDetail[] $tradeDetails
 */
class Trade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'money'], 'required'],
            [['customer_id'], 'integer'],
            [['time'], 'safe'],
            [['money'], 'number'],
            [['done'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Trade ID'),
            'customer_id' => Yii::t('app', 'Customer'),
            'time' => Yii::t('app', 'Time'),
            'money' => Yii::t('app', 'Money'),
            'done' => Yii::t('app', 'Done'),
            'detailCount' => Yii::t('app', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiveMoneys()
    {
        return $this->hasMany(ReceiveMoney::className(), ['trade_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTradeDetails()
    {
        return $this->hasMany(TradeDetail::className(), ['trade_id' => 'id']);
    }

    public function getDetailCount()
    {
        return $this->getTradeDetails()
            ->sum('count');
    }

    public static function createMultiple($modelClass, $mutipleModels = [])
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models=[];

        if(! empty($mutipleModels)) {
            $keys = array_keys(ArrayHelper::map($mutipleModels, 'id', 'id'));
            $mutipleModels = array_combine($keys, $mutipleModels);
        }

        if($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id'])
                && isset($mutipleModels[$item['id']])) {
                    $models[] = $mutipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }
        unset($model, $formName, $post);
        return $models;
    }
}
