<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stockin_detail".
 *
 * @property integer $id
 * @property integer $stockin_id
 * @property integer $product_id
 * @property integer $count
 *
 * @property Stockin $stockin
 * @property Product $product
 */
class StockinDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stockin_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // delete the stockin_id for valid the StockinController
            [['product_id', 'count'], 'required'],
            [['stockin_id', 'product_id', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'stockin_id' => Yii::t('app', 'Stockin ID'),
            'product_id' => Yii::t('app', 'Product'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockin()
    {
        return $this->hasOne(Stockin::className(), ['id' => 'stockin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
