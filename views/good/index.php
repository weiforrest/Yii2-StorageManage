<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Goods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Modal::begin([
    'header' => '<h1>'.Yii::t('app', 'Create Good').'</h1>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id = 'modalContent'></div>";
Modal::end();
?>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'bordered' => false,
    'toolbar' => [
        ['content' => Html::button(Yii::t('app', 'Create Good'),
        ['value' => Url::to('index.php?r=good/create'),
        'id' => 'modalButton',
        'class' => 'btn btn-success'])
    ],
],
'panel' => [
    'type' => GridView::TYPE_PRIMARY,
    'heading' => Yii::t('app', 'Good'),
],
'columns' => [
    ['class' => 'kartik\grid\SerialColumn'],

    [
        'attribute' => 'name',
        'format' => 'raw',
        'width' => '20%',
        'value' => function ($model, $key, $index, $widget) {
            return Html::a($model->name,
                'index.php?r=good%2Fview&id='.$model->id
            );
        }
],
    [
        'attribute' => 'unit',
        'value' => function ($model, $key, $index, $widget) {
            return $model->unit == 'X' ? Yii::t('app', 'Box') :Yii::t('app', 'Piece');
        }
    ],
    [
        'attribute' => 'num',
    ],
    [
        'attribute' => 'price',
    ],
    [
        'attribute' => 'cost',
    ],

    //            ['class' => 'kartik\grid\ActionColumn'],
],
    ]); ?>
</div>
