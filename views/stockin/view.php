<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Stockin */
/* @var $detail app\models\StockinDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stockins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stockin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
        'method' => 'post',
    ],
]) ?>
    </p>


    <h2> <?= Yii::t('app','Time') . ': ' . $model->time; ?> </h2>
    <h2> <?= Yii::t('app','Money'). ': ' . $model->money; ?> </h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'style'=>'text-align:center',
        'class' => 'table table-striped table-bordered',
    ],
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'product_id',
            'value' => 'product.name',
        ],
        'count',
        [
            'label' => Yii::t('app', 'Summary'),
            'class' => 'yii\grid\DataColumn',
            'format' => ['decimal', 2],
            'value' => function($model){
                return $model->product->unit == 'B' ?
                    $model->count * $model->product->price:
                    $model->count * $model->product->price * $model->product->specification;
            }
        ],
],
    ]) ?>


</div>
