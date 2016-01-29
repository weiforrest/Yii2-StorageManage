<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Input */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app', 'Input'),
]) . ' ' . $model->input_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inputs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->input_id, 'url' => ['view', 'id' => $model->input_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="input-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
