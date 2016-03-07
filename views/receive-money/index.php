<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReceiveMoneySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Receive');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receive-money-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => false,
        'tableOptions' => [
            'style'=>'text-align:center',
        ],
        'toolbar' => [
            ['content' => Html::a(Yii::t('app', 'Create Receive'),
                ['create'],
                ['class' => 'btn btn-success'])
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Receive'),
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '5%'
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
            ],
            [
                'attribute' => 'card_id',
                'value' => 'card.name',
                'pageSummary' => Yii::t('app', 'Total'),
            ],
            [
//                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'money',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            ['class' => 'kartik\grid\ActionColumn',
                'updateOptions' => ['hidden'=> true],
                'deleteOptions' => ['hidden' => true],
            ],
        ],
        'showPageSummary' => true,
    ]); ?>

</div>
