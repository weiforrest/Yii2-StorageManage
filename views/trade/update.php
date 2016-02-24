<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trade */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Trade',
]) . ' ' . $model->trade_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trade_id, 'url' => ['view', 'id' => $model->trade_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="trade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelDetails' => $modelDetails,
    ]) ?>

</div>
