<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Show</h1>
<ul>
<?php foreach ($goods as $good) : ?>
	<li>
		<?= Html::encode("{$good->good_id}") ?> :
		<?= $good->name ?>
	</li>
<?php endforeach; ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
