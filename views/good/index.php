<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
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



<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

            //'good_id',
            [
				'attribute' => 'name',
                'hAlign' => 'center',
				'format' => 'raw',
				'width' => '20%',
				'value' => function ($model, $key, $index, $widget) {
					return Html::a($model->name,
						'index.php?r=good%2Fview&id='.$model->good_id
					);
				}
			],
            [
				'attribute' => 'unit',
                'hAlign' => 'center',
			],
            [
				'attribute' => 'price',
                'hAlign' => 'center',
			],
            [
				'attribute' => 'cost',
                'hAlign' => 'center',
			],
            // 'enable',

//            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
