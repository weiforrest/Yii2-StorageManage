<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'condensed' => true,
    'layout' => '{items}{pager}',
    'rowOptions' => ['class' => 'info'],
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'good_id',
            'value' => 'good.name',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'count',
            'hAlign' => 'center',
        ],
    ],
]) ?>
