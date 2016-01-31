<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::button(Yii::t('app', 'Create Customer'),
			[ 'value' => Url::to('index.php?r=customer/create'),
		   	'id' => 'modalButton',
		   	'class' => 'btn btn-success']) ?>
    </p>

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'customer_id',
            'name',
            'telphone',
            'time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
