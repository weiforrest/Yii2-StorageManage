<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_detail".
 *
 * @property integer $id
 * @property integer $delivery_id
 * @property integer $product_id
 * @property integer $count
 * @property string $price
 *
 * @property Delivery $delivery
 * @property Product $product
 */
class DeliveryDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // delete the delivery_id in required for valid in controller
            [[ 'count', 'price'], 'required'],
            [['delivery_id', 'product_id', 'count'], 'integer'],
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
            'delivery_id' => Yii::t('app', 'Delivery ID'),
            'product_id' => Yii::t('app', 'Product'),
            'count' => Yii::t('app', 'Count'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::className(), ['id' => 'delivery_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
