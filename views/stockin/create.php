<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Stockin */

$this->title = Yii::t('app', 'Create Stockin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stockins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stockin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'modelDetails' => $modelDetails,
    ]) ?>

</div>
