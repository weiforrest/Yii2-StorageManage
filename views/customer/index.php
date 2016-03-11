<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'bordered' => false,
    'toolbar' => [
        [
            'content' => Html::a(Yii::t('app', 'Create Customer'),
            ['create'],
            ['class' => 'btn btn-success'])
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Customer'),
    ],
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '5%'
        ],

        [
            'attribute' => 'name',
            'format' => 'raw',
            'width' => '10%',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->name,
                    'index.php?r=customer%2Fview&id='.$model->id
                );
            }
        ],
        [
            'width' => '40%',
            'attribute' => 'info',
        ],
        [
            'attribute' => 'time',
            'format' => ['datetime','php:Y-m-d'],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => [
                'presetDropdown' => true,
                'pluginOptions' => [
                    'locale' => [
                        'separator' => ' to ',
                        'format' => 'YYYY-MM-DD',
                    ],
                ],
            ],
        ],
        [
            'attribute' => 'sum',
            'width' => '10%',
            'format' => ['decimal', 2],
        ],
        [
            'attribute' => 'payed',
            'width' => '10%',
            'format' => ['decimal', 2],
        ],
        [
            'attribute' => 'unpay',
            'width' => '10%',
            'format' => ['decimal', 2],
        ],
    ],
]); ?>

</div>
