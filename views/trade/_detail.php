<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'condensed' => true,
    'rowOptions' => [
        'class' => 'info',
    ],
    'layout' => '{items}{pager}',
//    'filterModel' => $searchModel,
//    'summary' => "Showing {begin} - {end} of {totalCount} items",
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'good_id',
            'value' => 'good.name',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'count',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'price',
            'hAlign' => 'center',
        ],
        [
            'hAlign' => 'center',
            'label' => Yii::t('app','Summary'),
            'format' => ['decimal', 2],
            'class' => 'kartik\grid\FormulaColumn',
            'value' => function($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                return $widget->col(3, $p) * $widget->col(2, $p);
            },

        ],
    ],
]) ?>
