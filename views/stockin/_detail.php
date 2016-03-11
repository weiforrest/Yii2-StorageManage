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
    'layout' => '{items}{pager}',
    'rowOptions' => ['class' => 'info'],
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'product_id',
            'value' => 'product.name',
        ],
        [
            'attribute' => 'count',
        ],
        [
            'label' => Yii::t('app', 'Summary'),
            'format' => ['decimal', 2],
            'class' => 'kartik\grid\FormulaColumn',
            'value' => function($model, $key, $index, $widget) {
                return $model->product->unit == 'B' ?
                    $model->count * $model->product->price:
                    $model->count * $model->product->price * $model->product->specification;
            }

        ]
    ],
]) ?>
