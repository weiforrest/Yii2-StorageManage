<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Good;
use app\models\Customer;
/* @var $this yii\web\View */
/* @var $model app\models\Trade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $form->field($model, 'time')->textInput() ?>
            <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(), 'customer_id', 'name'),
                ['prompt' => Yii::t('app','Select Customer')]
            ) ?>
            <?= $form->field($model, 'money')->textInput() ?>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-items',
                    'widgetItem' => '.item',
                    'limit' => 10,
                    'min' => 1,
                    'insertButton' => '.add-item',
                    'deleteButton' => '.remove-item',
                    'model' => $modelDetails[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'good_id',
                        'count',
                        'price'
                    ],
                ]); ?>
                <div class="container-items">
                    <?php foreach ($modelDetails as $i => $modelDetail): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Good') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (! $modelDetail->isNewRecord) {
                                    echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($modelDetail, "[{$i}]good_id")->dropDownList(
                                            ArrayHelper::map(Good::find()->all(), 'good_id', 'name'),
                                            [
                                                'prompt' => Yii::t('app','Select Good'),
                                                'onchange' => ''
                                            ]
                                        )?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelDetail, "[{$i}]count")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelDetail, "[{$i}]price")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
