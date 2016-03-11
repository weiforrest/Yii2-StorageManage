<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

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
            'content' => Html::a(Yii::t('app', 'Create Product'),
            ['create'],
            ['class' => 'btn btn-success'])
        ],
    ],
'panel' => [
    'type' => GridView::TYPE_PRIMARY,
    'heading' => Yii::t('app', 'Product'),
],
'columns' => [
    ['class' => 'kartik\grid\SerialColumn'],

    [
        'attribute' => 'name',
        'format' => 'raw',
        'width' => '20%',
        'value' => function ($model, $key, $index, $widget) {
            return Html::a($model->name,
                'index.php?r=product%2Fview&id='.$model->id
            );
        }
],
    [
        'attribute' => 'unit',
        'value' => function ($model, $key, $index, $widget) {
            return $model->unit == 'B' ? Yii::t('app', 'Box') :Yii::t('app', 'Piece');
        }
    ],
    [
        'attribute' => 'specification',
    ],
    [
        'attribute' => 'price',
    ],
    [
        'attribute' => 'cost',
    ],

],
    ]); ?>
</div>
