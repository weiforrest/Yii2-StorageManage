<?php

namespace app\controllers;

use Yii;
use app\models\ReceiveMoney;
use app\models\ReceiveMoneySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ReceiveMoneyController implements the CRUD actions for ReceiveMoney model.
 */
class ReceiveMoneyController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ReceiveMoney models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiveMoneySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReceiveMoney model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReceiveMoney model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReceiveMoney();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // add the money to customer
            $customer = $model->customer;
            $customer->payed += $model->money;
            $customer->unpay -= $model->money;
            $customer->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReceiveMoney model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldMoney = $model->money;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // update the money to customer
            $customer = $model->customer;
            $customer->unpay += $oldMoney;
            $customer->payed -= $oldMoney;
            $customer->payed += $model->money;
            $customer->unpay -= $model->money;
            $customer->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ReceiveMoney model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // delete the money to customer
        $customer = $model->customer;
        $customer->unpay += $model->money;
        $customer->payed -= $model->money;
        $customer->save();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReceiveMoney model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReceiveMoney the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReceiveMoney::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
