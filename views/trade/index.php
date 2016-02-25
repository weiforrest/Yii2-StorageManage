<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\TradeDetailSearch;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Trades');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => [
            ['content' => Html::a(Yii::t('app', 'Create Trade'),
                ['create'],
                ['class' => 'btn btn-success'])
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Trades'),
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
                'detail' => function ($model, $key, $index, $columu) {
                    $searchModel = new TradeDetailSearch();
                    $searchModel->trade_id = $model->id;
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
                'hAlign' => 'center',
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
                'hAlign' => 'center',
                'pageSummary' => Yii::t('app','Total'),
            ],
            [
//                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'money',
                'hAlign' => 'center',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'attribute' => 'detailCount',
                'hAlign' => 'center',
                'pageSummary' => true,
            ],
            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'showPageSummary' => true,
    ]); ?>
    <?php Pjax::end(); ?>

</div>
