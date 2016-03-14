<?php

namespace app\controllers;

use Yii;
use app\models\Delivery;
use app\models\DeliveryDetail;
use app\models\DeliverySearch;
use app\models\DeliveryDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * DeliveryController implements the CRUD actions for Delivery model.
 */
class DeliveryController extends Controller
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
     * Lists all Delivery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Delivery model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new DeliveryDetailSearch();
        $model = $this->findModel($id);
        $searchModel->delivery_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Delivery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Delivery();
        $modelDetails = [new DeliveryDetail];

        if ($model->load(Yii::$app->request->post())) {
            $modelDetails = Delivery::createMultiple(DeliveryDetail::className());
            Delivery::loadMultiple($modelDetails, Yii::$app->request->post());

            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->request->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetails),
                    ActiveForm::validate($model)
                );
            }

            // set the time
            if ($model->time) {
                date_default_timezone_set("Asia/ShangHai");
                $model->time .= ("  ". date("H:i:s"));
            }
            //validate all models
            $valid = $model->validate();
            $profit=0;
            $valid = Delivery::validateMultiple($modelDetails) && $valid;
            if ($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->delivery_id = $model->id;
                            //count the profit;
                            $profit += $modelDetail->count *
                                ($modelDetail->price -
                            ($modelDetail->product->unit =='B' ?
                                $modelDetail->product->cost:
                                $modelDetail->product->cost * $modelDetail->product->specification));
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
                        // save the profit
                        $model->profit = $profit;
                        $model->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transcation->rollBack();
                }
            }
        }
        return $this->render('create', [
                'model' => $model,
                'modelDetails' => (empty($modelDetails)) ? [new DeliveryDetail] : $modelDetails,
            ]);
    }

    /**
     * Updates an existing Delivery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldMoney = $model->money;
        $modelDetails = $model->deliveryDetails;

        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelDetails, 'id', 'id');
            $modelDetails = Delivery::createMultiple(DeliveryDetail::className(), $modelDetails);
            Delivery::loadMultiple($modelDetails, Yii::$app->request->post());
            $deleteIDS = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));

            //ajax validation
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetails),
                    ActiveForm::validate($model)
                );
            }

            // set the time
            if ($model->time) {
                date_default_timezone_set("Asia/ShangHai");
                $model->time .= ("  ". date("H:i:s"));
            }
            //validate all models
            $valid = $model->validate();
            $valid = Delivery::validateMultiple($modelDetails) && $valid;
            $profit = 0;

            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        if(!empty($deleteIDS)) {
                            DeliveryDetail::deleteAll(['id' => $deleteIDS]);
                        }
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->delivery_id = $model->id;
                            //count the profit;
                            $profit += $modelDetail->count *
                                ($modelDetail->price -
                                    ($modelDetail->product->unit =='B' ?
                                        $modelDetail->product->cost:
                                        $modelDetail->product->cost * $modelDetail->product->specification));
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
                        // save the profit
                        $model->profit = $profit;
                        $model->save();
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
                'modelDetails' => (empty($modelDetails)) ? [new DeliveryDetail] : $modelDetails
            ]);
    }

    /**
     * Deletes an existing Delivery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        DeliveryDetail::deleteAll(['delivery_Id' => $id]);
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
     * Finds the Delivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Delivery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Delivery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
