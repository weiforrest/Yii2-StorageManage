<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "input".
 *
 * @property integer $input_id
 * @property string $time
 *
 * @property InputDetail[] $inputDetails
 * @property Good[] $goods
 */
class Input extends \yii\db\ActiveRecord
{
	/*
	 *for sum of input_detail
	 */
	public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'input';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'input_id' => Yii::t('app', 'Input ID'),
            'time' => Yii::t('app', 'Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputDetails()
    {
        return $this->hasMany(InputDetail::className(), ['input_id' => 'input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['good_id' => 'good_id'])->viaTable('input_detail', ['input_id' => 'input_id']);
    }
}
