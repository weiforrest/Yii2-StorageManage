<?php
/*it is about the longji web application controller */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

/*
 *use the Good ActiveRecord
 */
use app\models\Good;

class GoodController extends Controller
{
	public function actionShow()
	{
		$query = Good::find();
		$pagination =  new Pagination([
			'defaultPageSize' => 5,
			'totalCount' => $query->count(),
		]);

		$goods = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		/*
		 * this return value is represents the response data
		 * to be send to end users
		 *return "Show this return value";
		 */
		return $this->render('showall',[
			'goods' => $goods,
			'pagination' => $pagination,
		]);

	}
}


?>
