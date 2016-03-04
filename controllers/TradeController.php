<?php

namespace app\controllers;

use Yii;
use app\models\Trade;
use app\models\TradeDetail;
use app\models\TradeSearch;
use app\models\TradeDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * TradeController implements the CRUD actions for Trade model.
 */
class TradeController extends Controller
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
     * Lists all Trade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TradeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trade model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new TradeDetailSearch();
        $model = $this->findModel($id);
        $searchModel->trade_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Trade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trade();
        $modelDetails = [new TradeDetail];

        if ($model->load(Yii::$app->request->post())) {
            $modelDetails = Trade::createMultiple(TradeDetail::className());
            Trade::loadMultiple($modelDetails, Yii::$app->request->post());

            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->request->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetails),
                    ActiveForm::validate($model)
                );
            }

            //validate all models
            $valid = $model->validate();
            $valid = Trade::validateMultiple($modelDetails) && $valid;
            if ($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->trade_id = $model->id;
                            if( ! ($flag = $modelDetail->save(false))) {
                                $transcation->rollBack();
                            }
                        }
                    }
                    if($flag) {
                        $transcation-> commit();
                        //add the money to customer
                        $customer = $model->customer;
                        $customer->unpay +=$model->money;
                        $customer->sum += $model->money;
                        $customer->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transcation->rollBack();
                }
            }
        }
        return $this->render('create', [
                'model' => $model,
                'modelDetails' => (empty($modelDetails)) ? [new TradeDetail] : $modelDetails,
            ]);
    }

    /**
     * Updates an existing Trade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldMoney = $model->money;
        $modelDetails = $model->tradeDetails;

        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelDetails, 'id', 'id');
            $modelDetails = Trade::createMultiple(TradeDetail::className(), $modelDetails);
            Trade::loadMultiple($modelDetails, Yii::$app->request->post());
            $deleteIDS = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));

            //ajax validation
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetails),
                    ActiveForm::validate($model)
                );
            }

            //validate all models
            $valid = $model->validate();
            $valid = Trade::validateMultiple($modelDetails) && $valid;

            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        if(!empty($deleteIDS)) {
                            TradeDetail::deleteAll(['id' => $deleteIDS]);
                        }
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->trade_id = $model->id;
                            if( ! ($flag = $modelDetail->save(false))) {
                                $transcation->rollBack();
                            }
                        }
                    }
                    if($flag) {
                        //update the money to customer
                        $customer = $model->customer;
                        $customer->unpay -=$oldMoney;
                        $customer->sum -= $oldMoney;
                        $customer->unpay += $model->money;
                        $customer->sum += $model->money;
                        $customer->save();
                        $transcation->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transcation->rollBack();
                }
            }
        }
        return $this->render('update', [
                'model' => $model,
                'modelDetails' => (empty($modelDetails)) ? [new TradeDetail] : $modelDetails
            ]);
    }

    /**
     * Deletes an existing Trade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TradeDetail::deleteAll(['trade_Id' => $id]);
        $model = $this->findModel($id);

        //delete the money to customer
        $customer = $model->customer;
        $customer->unpay -=$model->money;
        $customer->sum -= $model->money;
        $customer->save();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Trade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trade::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
