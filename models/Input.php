<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "input".
 *
 * @property integer $id
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
            'id' => Yii::t('app', 'Input ID'),
            'time' => Yii::t('app', 'Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputDetails()
    {
        return $this->hasMany(InputDetail::className(), ['input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['good_id' => 'good_id'])->viaTable('input_detail', ['input_id' => 'id']);
    }

	public static function createMultiple($modelClass, $multipleModels = [])
	{
		$model = new $modelClass;
		$formName = $model->formName();
		$post = Yii::$app->request->post($formName);
		$models = [];

		if(! empty($multipleModels)) {
			$keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
			$multipleModels = array_combine($keys, $multipleModels);
		}

		if($post && is_array($post)) {
			foreach ($post as $i => $item) {
				if (isset($item['id']) && !empty($item['id'])
					&& isset($multipleModels[$item['id']])) {
					$models[] = $multipleModels[$item['id']];
				} else {
					$models[] = new $modelClass;
				}
			}
		}
		unset($model, $formName, $post);
		return $models;
	}
}
