<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::button(Yii::t('app', 'Create Good'),
			[ 'value' => Url::to('index.php?r=good/create'),
		   	'id' => 'modalButton',
		   	'class' => 'btn btn-success']) ?>
    </p>

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'good_id',
            'name',
            'unit',
            'price',
            'cost',
            // 'enable',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
