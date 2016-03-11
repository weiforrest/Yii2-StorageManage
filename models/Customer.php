<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $time
 * @property string $unpay
 * @property string $payed
 * @property string $sum
 *
 * @property Collection[] $collections
 * @property Delivery[] $deliveries
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'info'], 'required'],
            [['time', 'unpay', 'payed', 'sum'], 'safe'],
            [['unpay', 'payed', 'sum'], 'number'],
            [['name', 'info'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'info' => Yii::t('app', 'Info'),
            'time' => Yii::t('app', 'Time'),
            'unpay' => Yii::t('app', 'Unpay'),
            'payed' => Yii::t('app', 'Payed'),
            'sum' => Yii::t('app', 'Sum'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollections()
    {
        return $this->hasMany(Collection::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveries()
    {
        return $this->hasMany(Delivery::className(), ['customer_id' => 'id']);
    }
}
