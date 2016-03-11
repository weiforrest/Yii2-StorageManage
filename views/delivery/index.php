<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\DeliveryDetailSearch;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Deliveries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => false,
        'tableOptions' => [
            'style'=>'text-align:center',
        ],
        'rowOptions' => ['class' => 'danger'],
        'toolbar' => [
            ['content' => Html::a(Yii::t('app', 'Create Delivery'),
                ['create'],
                ['class' => 'btn btn-success'])
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Deliveries'),
        ],
//        'pageSummaryRowOptions' => [
//            'class' => 'kv-page-summary warning',
//        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '5%'
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new DeliveryDetailSearch();
                    $searchModel->delivery_id = $model->id;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return Yii::$app->controller->renderPartial('_detail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                },
            ],
            [
                'attribute' => 'time',
                'format' => ['date','php:Y-m-d'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'presetDropdown' => true,
//                    'hideInput' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'separator' => ' to ',
                            'format' => 'YYYY-MM-DD',
                        ],
                    ],
                ],
            ],
            [
                'attribute' => 'customer_id',
                'value' => 'customer.name',
                'pageSummary' => Yii::t('app','Total'),
            ],
            [
                'attribute' => 'detailCount',
                'pageSummary' => true,
            ],
            [
//                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'money',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'attribute' => 'profit',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'updateOptions' => ['hidden'=> true],
                'deleteOptions' => ['hidden' => true],
            ],
        ],
        'showPageSummary' => true,
    ]); ?>

</div>
