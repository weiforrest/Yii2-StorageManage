<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Good;

/* @var $this yii\web\View */
/* @var $model app\models\Input */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
function updateMoney(){
    var money = new Number(0);
    $(".detail-total").each(function(){
    var detail = new Number($(this).html());
    money += detail;
    });
    $("#input-money").val(money.toFixed(2));
}

var prices;
$(document).ready(function(){
    $.post("index.php?r=good/prices",function (data) {
        prices = JSON.parse(data);
    });
});

function getPrice(id) {
    var toReturn;
    $.each(prices, function(i,v){
        if(v.good_id == id){
            toReturn = v.price;
            return false;
        }
    });
    return toReturn;
}

$("body").on("change",".detail-good-id", function handleGood(){
    var count_item = $(this).parent().parent().next().children().children(".detail-count");
    var price_item = count_item.parent().parent().next().next().children("em");
    var total_item = price_item.parent().next().children("em");
    count = count_item.val()
    var good_id = $(this).val();
    if(good_id !== ""){
        price = getPrice(good_id);
        price_item.html(price);
        if(count !="") {
             total_item.html((price * count).toFixed(2));
        }
    }else{
        price_item.html("0.00");
        total_item.html("0.00");
    }
    updateMoney();
});

$("body").on("change",".detail-count",function() {
    var good_item = $(this).parent().parent().prev().children().children(".detail-good-id");
    var total_item = $(this).parent().parent().next().next().next().children("em");
    count = $(this).val();
    var good_id = good_item.val();
    if(!isNaN(count)){
        price = getPrice(good_id);
        total_item.html((price * count).toFixed(2));
        updateMoney();
    }
});
JS;

$this->registerJs($js, $this::POS_END);

?>

<div class="input-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'time')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'money')->textInput() ?>
                </div>
            </div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-items',
                    'widgetItem' => '.item',
                    'limit' => 10,
                    'min' => 2,
                    'insertButton' => '.add-item',
                    'deleteButton' => '.remove-item',
                    'model' => $modelDetails[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'good_id',
                        'count'
                    ],
                ]); ?>
                <div class="container-items">
                    <?php foreach ($modelDetails as $i => $modelDetail): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Good') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (!$modelDetail->isNewRecord) {
                                    echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($modelDetail, "[{$i}]good_id")->dropDownList(
                                            ArrayHelper::map(Good::find()->all(), 'good_id', 'name'),
                                            [
                                                'prompt' => Yii::t('app','Select Good'),
                                                'class' => 'form-control detail-good-id',
                                            ]
                                        ) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelDetail, "[{$i}]count")->textInput([
                                            'maxlength' => true,
                                            'class' => 'form-control detail-count',
                                        ]) ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-sm-6">
                                        <strong><?= Yii::t('app', 'Price').' : ' ?></strong>
                                        <em class="pull-right">
                                        <?php
                                        if($modelDetail->good) {
                                            echo number_format($modelDetail->good->price, 2, '.', '');
                                        }else {
                                            echo '0.00';
                                        }
                                        ?>
                                        </em>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <strong><?= Yii::t("app", 'Total').' : ' ?></strong>
                                        <em class="pull-right detail-total">
                                        <?php
                                        if($modelDetail->good) {
                                            echo number_format($modelDetail->good->price * $modelDetail->count, 2, '.','');
                                        }else {
                                            echo '0.00';
                                        }
                                        ?>
                                        </em>
                                    </div>
                                    <div class="clearfix"></div>
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
