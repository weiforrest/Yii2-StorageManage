<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $time
 * @property string $money
 * @property string $profit
 * @property string $state
 *
 * @property Customer $customer
 * @property DeliveryDetail[] $deliveryDetails
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
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
            [['money', 'profit'], 'number'],
            [['state'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', 'Customer'),
            'time' => Yii::t('app', 'Time'),
            'money' => Yii::t('app', 'Money'),
            'profit' => Yii::t('app', 'Profit'),
            'state' => Yii::t('app', 'State'),
            'detailCount' => Yii::t('app', 'Count'),
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
    public function getDeliveryDetails()
    {
        return $this->hasMany(DeliveryDetail::className(), ['delivery_id' => 'id']);
    }

    public function getDetailCount()
    {
        return $this->getDeliveryDetails()
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
