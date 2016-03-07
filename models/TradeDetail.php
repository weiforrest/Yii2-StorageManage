<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trade_detail".
 *
 * @property integer $id
 * @property integer $trade_id
 * @property integer $good_id
 * @property integer $count
 * @property string $price
 *
 * @property Trade $trade
 * @property Good $good
 */
class TradeDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trade_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_id', 'count', 'price'], 'required'],
            [['trade_id', 'good_id', 'count'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trade_id' => Yii::t('app', 'Trade ID'),
            'good_id' => Yii::t('app', 'Good'),
            'count' => Yii::t('app', 'Count'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrade()
    {
        return $this->hasOne(Trade::className(), ['trade_id' => 'trade_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
