<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "good".
 *
 * @property integer $good_id
 * @property string $name
 * @property string $unit
 * @property string $price
 * @property string $cost
 * @property string $enable
 *
 * @property InputDetail[] $inputDetails
 * @property Input[] $inputs
 * @property TradeDetail[] $tradeDetails
 * @property Trade[] $trades
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'unit', 'price', 'cost'], 'required'],
            [['unit', 'enable'], 'string'],
            [['price', 'cost'], 'number'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'good_id' => Yii::t('app', 'Good ID'),
            'name' => Yii::t('app', 'Name'),
            'unit' => Yii::t('app', 'Unit'),
            'price' => Yii::t('app', 'Price'),
            'cost' => Yii::t('app', 'Cost'),
            'enable' => Yii::t('app', 'Enable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputDetails()
    {
        return $this->hasMany(InputDetail::className(), ['good_id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputs()
    {
        return $this->hasMany(Input::className(), ['input_id' => 'input_id'])->viaTable('input_detail', ['good_id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTradeDetails()
    {
        return $this->hasMany(TradeDetail::className(), ['good_id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrades()
    {
        return $this->hasMany(Trade::className(), ['trade_id' => 'trade_id'])->viaTable('trade_detail', ['good_id' => 'good_id']);
    }
}
