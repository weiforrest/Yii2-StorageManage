<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReceiveMoney */

$this->title = Yii::t('app', 'Create Receive');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receive'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receive-money-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
