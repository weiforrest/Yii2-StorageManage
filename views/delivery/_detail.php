<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'condensed' => true,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'rowOptions' => [
        'class' => 'info',
    ],
    'layout' => '{items}{pager}',
//    'filterModel' => $searchModel,
//    'summary' => "Showing {begin} - {end} of {totalCount} items",
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
        ],
        [
            'attribute' => 'product_id',
            'value' => 'product.name',
        ],
        [
            'attribute' => 'count',
        ],
        [
            'attribute' => 'price',
        ],
        [
            'label' => Yii::t('app','Summary'),
            'format' => ['decimal', 2],
            'class' => 'kartik\grid\FormulaColumn',
            'value' => function($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                return $widget->col(3, $p) * $widget->col(2, $p);
            },

        ],
        [
            'label' => Yii::t('app', 'Profit'),
            'format' => ['decimal', 2],
            'value' => function($model, $key, $index, $widget) {
                return $model->count * ($model->price -
                    ($model->product->unit =='B' ?
                        $model->product->cost:
                        $model->product->cost * $model->product->specification));
            },
        ],
    ],
]) ?>
