<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\StockinDetailSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StockinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stockins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stockin-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'rowOptions' => ['class' => 'danger'],
    'bordered' => false,
    'toolbar' => [
        ['content' => Html::a(Yii::t('app', 'Create Stockin'),
        ['create'],
        ['class' => 'btn btn-success'])
    ],
],
'panel' => [
    'type' => GridView::TYPE_PRIMARY,
    'heading' => Yii::t('app', 'Stockins'),
],
'columns' => [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '5%',
    ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model, $key, $index, $column) {
            $searchModel = new StockinDetailSearch();
            $searchModel->stockin_id = $model->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return Yii::$app->controller->renderPartial('_detail', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        },
    ],
    [
        'attribute' => 'time',
        'width' => '30%',
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
        'pageSummary' => Yii::t('app','Total'),
    ],
    [
        'attribute' => 'detailCount',
        'width' => '20%',
        'pageSummary' => true,
    ],
    [
        'attribute' => 'money',
        'width' => '15%',
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
