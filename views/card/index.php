<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


	<?php Modal::begin([
		'header' => '<h1>'.Yii::t('app', 'Create Card').'</h1>',
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
			['content' => Html::button(Yii::t('app', 'Create Card'),
				['value' => Url::to('index.php?r=card/create'),
					'id' => 'modalButton',
					'class' => 'btn btn-success'])
			],
		],
		'panel' => [
			'type' => GridView::TYPE_PRIMARY,
			'heading' => Yii::t('app', 'Card'),
		],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'card_id',
			[
				'attribute' => 'name',
				'hAlign' => 'center',
			],
			[
				'attribute' => 'card_number',
				'hAlign' => 'center',
			],
            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
