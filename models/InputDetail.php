<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "input_detail".
 *
 * @property integer $input_id
 * @property integer $good_id
 * @property integer $count
 *
 * @property Input $input
 * @property Good $good
 */
class InputDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'input_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_id', 'count'], 'required'],
            [['input_id', 'good_id', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'input_id' => Yii::t('app', 'Input ID'),
            'good_id' => Yii::t('app', 'Good'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInput()
    {
        return $this->hasOne(Input::className(), ['id' => 'input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['good_id' => 'good_id']);
    }
}
