<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Account;
use app\models\Customer;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Collection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_id')->dropDownList(
        ArrayHelper::map(Account::find()->all(), 'id', 'name'),
        [
            'prompt' => Yii::t('app','Select Account'),
        ]
    ) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->dropDownList(
        ArrayHelper::map(Customer::find()->all(), 'id', 'name'),
        [
            'prompt' => Yii::t('app','Select Customer'),
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
