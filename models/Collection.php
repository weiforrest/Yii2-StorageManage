<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $time
 * @property string $money
 * @property integer $customer_id
 *
 * @property Customer $customer
 * @property Account $account
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'money', 'customer_id'], 'required'],
            [['account_id', 'customer_id'], 'integer'],
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
            'account_id' => Yii::t('app', 'Account'),
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
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }
}
