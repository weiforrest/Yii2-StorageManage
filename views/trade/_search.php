<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TradeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'trade_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'money') ?>

    <?= $form->field($model, 'done') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
