<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Input */
/* @var $detail app\models\InputDetail */

$this->title = $model->input_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inputs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="input-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->input_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->input_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

	
	<h2> <?= Yii::t('app','Time' ) . ': ' . $model->time; ?> </h2>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'good_id', 
				'value' => 'good.name',
			],
			'count',
		],
	]) ?>
	


</div>