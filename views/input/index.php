<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\InputDetailSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InputSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inputs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="input-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => [
            ['content' => Html::a(Yii::t('app', 'Create Input'),
                    ['create'],
                    ['class' => 'btn btn-success'])
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Inputs'),
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
                    $searchModel = new InputDetailSearch();
                    $searchModel->input_id = $model->id;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return Yii::$app->controller->renderPartial('_detail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);

                },
            ],
            [
                'attribute' => 'time',
                'width' => '40%',
                'hAlign' => 'center',
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
                'width' => '33%',
                'hAlign' => 'center',
                'pageSummary' => true,
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
            ],
        ],
        'showPageSummary' => true,
    ]); ?>
<?php Pjax::end(); ?>

</div>
