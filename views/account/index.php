<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'style'=>'text-align:center',
    ],
    'bordered' => false,
    'toolbar' => [
        [
            'content' => Html::a(Yii::t('app', 'Create Account'),
            ['create'],
            ['class' => 'btn btn-success'])
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Account'),
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'width' => '40%',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->name,
                    'index.php?r=account%2Fview&id='.$model->id
                );
            }
        ],
        [
            'attribute' => 'card_number',
        ],
    ],
]); ?>
</div>
