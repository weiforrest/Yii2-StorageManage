<?php

namespace app\controllers;

use Yii;
use app\models\Stockin;
use app\models\StockinDetail;
use app\models\StockinSearch;
use app\models\StockinDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * StockinController implements the CRUD actions for Stockin model.
 */
class StockinController extends Controller
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
     * Lists all Stockin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stockin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new StockinDetailSearch();
        $model = $this->findModel($id);
        $searchModel->stockin_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Stockin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stockin();
        $modelDetails = [new  StockinDetail];

        if ($model->load(Yii::$app->request->post())) {
            $modelDetails = Stockin::createMultiple(StockinDetail::classname());
            Stockin::loadMultiple($modelDetails, Yii::$app->request->post());

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
            $valid = Stockin::validateMultiple($modelDetails) && $valid;
            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->stockin_id = $model->id;
                            if( ! ($flag = $modelDetail->save(false))) {
                                $transcation->rollBack();
                            }
                        }
                    }
                    if($flag) {
                        $transcation->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transcation->rollBack();
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelDetails' => (empty($modelDetails)) ? [new StockinDetail] :  $modelDetails,
        ]);
    }

    /**
     * Updates an existing Stockin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetails = $model->stockinDetails;

        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelDetails, 'id', 'id');
            $modelDetails = Stockin::createMultiple(StockinDetail::classname(), $modelDetails);
            Stockin::loadMultiple($modelDetails, Yii::$app->request->post());
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
            $valid = Stockin::validateMultiple($modelDetails) && $valid;

            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        if(!empty($deleteIDS)){
                            StockinDetail::deleteAll(['id' => $deleteIDS]);
                        }
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->stockin_id = $model->id;
                            if( ! ($flag = $modelDetail->save(false))) {
                                $transcation->rollBack();
                            }
                        }
                    }
                    if($flag) {
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
            'modelDetails' => (empty($modelDetails)) ? [new StockinDetail] :  $modelDetails
        ]);
    }

    /**
     * Deletes an existing Stockin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        StockinDetail::deleteAll(['stockin_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stockin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stockin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stockin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
