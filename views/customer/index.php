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
            ['class' => 'kartik\grid\SerialColumn'],

            //'customer_id',
			[
				'hAlign' => 'center',
				'attribute' => 'name',
			],
			[
				'hAlign' => 'center',
				'attribute' => 'telphone',
			],
			[
				'attribute' => 'time',
				'width' => '40%',
				'hAlign' => 'center',
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
            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
