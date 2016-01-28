<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $card_id
 * @property string $name
 * @property string $card_number
 *
 * @property ReceiveMoney[] $receiveMoneys
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'card_number'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['card_number'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => Yii::t('app', 'Card ID'),
            'name' => Yii::t('app', 'Name'),
            'card_number' => Yii::t('app', 'Card Number'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiveMoneys()
    {
        return $this->hasMany(ReceiveMoney::className(), ['card_id' => 'card_id']);
    }
}
