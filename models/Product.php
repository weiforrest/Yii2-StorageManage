<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $unit
 * @property integer $specification
 * @property string $price
 * @property string $cost
 *
 * @property DeliveryDetail[] $deliveryDetails
 * @property StockinDetail[] $stockinDetails
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'specification', 'price', 'cost'], 'required'],
            [['unit'], 'string'],
            [['specification'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'unit' => Yii::t('app', 'Unit'),
            'specification' => Yii::t('app', 'Specification'),
            'price' => Yii::t('app', 'Price'),
            'cost' => Yii::t('app', 'Cost'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryDetails()
    {
        return $this->hasMany(DeliveryDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockinDetails()
    {
        return $this->hasMany(StockinDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockins()
    {
        return $this->hasMany(Stockin::className(), ['id' => 'stockin_id'])->viaTable('stockin_detail', ['product_id' => 'id']);
    }

}
