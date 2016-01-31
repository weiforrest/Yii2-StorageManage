<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::button(Yii::t('app', 'Create Card'), [
			'value' => Url::to('index.php?r=card/create'),
		   	'id' => 'modalButton',
			'class' => 'btn btn-success'])
		?>
    </p>

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'card_id',
            'name',
            'card_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
