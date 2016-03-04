<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Modal::begin([
    'header' => '<h1>'.Yii::t('app', 'Create Customer').'</h1>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id = 'modalContent'></div>";
Modal::end();
?>

<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'bordered' => false,
    'toolbar' => [
        ['content' => Html::button(Yii::t('app', 'Create Customer'),
        ['value' => Url::to('index.php?r=customer/create'),
        'id' => 'modalButton',
        'class' => 'btn btn-success'])
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

    //'customer_id',
    [
        'attribute' => 'name',
        'format' => 'raw',
        'width' => '10%',
        'value' => function ($model, $key, $index, $widget) {
            return Html::a($model->name,
                'index.php?r=customer%2Fview&id='.$model->customer_id
            );
        }
],
    [
        'width' => '20%',
        'attribute' => 'telphone',
    ],
    [
        'attribute' => 'time',
        'format' => ['datetime','php:Y-m-d'],
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
    //            ['class' => 'kartik\grid\ActionColumn'],
],
    ]); ?>
<?php Pjax::end(); ?>

</div>
