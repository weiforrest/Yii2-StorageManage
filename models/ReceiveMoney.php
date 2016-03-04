<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receive_money".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $time
 * @property string $money
 * @property integer $customer_id
 *
 * @property Customer $customer
 * @property Card $card
 */
class ReceiveMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receive_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'money', 'customer_id'], 'required'],
            [['card_id', 'customer_id'], 'integer'],
            [['time'], 'safe'],
            [['money'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'card_id' => Yii::t('app', 'Card'),
            'time' => Yii::t('app', 'Time'),
            'money' => Yii::t('app', 'Money'),
            'customer_id' => Yii::t('app', 'Customer'),
        ];
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
    public function getCard()
    {
        return $this->hasOne(Card::className(), ['card_id' => 'card_id']);
    }
}
