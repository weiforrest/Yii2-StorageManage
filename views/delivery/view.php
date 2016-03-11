<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $detail app\models\DeliveryDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deliveries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer.name',
            'time',
            'money',
            'profit',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'tableOptions' => [
            'style'=>'text-align:center',
            'class' => 'table table-striped table-bordered',
        ],
        'showPageSummary' => true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'product_id',
                'value' => 'product.name',
            ],
            'count',
            [
                'attribute' => 'price',
                'pageSummary' => Yii::t('app','Total'),
            ],
            [
                'label' => Yii::t('app', 'Summary'),
                //'class' => 'kartik\grid\DataColumn',
                'format' => ['decimal', 2],
                'value' => function($model) {
                    return $model->count * $model->price;
                },
                'pageSummary' => true,
            ],
            [
                'label' => Yii::t('app', 'Profit'),
                //'class' => 'yii\grid\DataColumn',
                'format' => ['decimal', 2],
                'value' => function($model, $key, $index, $widget) {
                    return $model->count * ($model->price -
                        ($model->product->unit =='B' ?
                            $model->product->cost:
                            $model->product->cost * $model->product->specification));
                },
                'pageSummary' => true,
            ],
        ],
    ]) ?>

</div>
