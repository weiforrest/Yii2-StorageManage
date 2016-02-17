<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\InputDetailSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InputSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inputs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="input-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Input'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new InputDetailSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->id);

                    return Yii::$app->controller->renderPartial('_detail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);

                },
            ],

            'id',
            'time',
			['label' => Yii::t('app', 'Count'), 'attribute' => 'count', 'value' => 'count'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
