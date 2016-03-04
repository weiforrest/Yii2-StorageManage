<?php

namespace app\controllers;

use Yii;
use app\models\Input;
use app\models\InputDetail;
use app\models\InputSearch;
use app\models\InputDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * InputController implements the CRUD actions for Input model.
 */
class InputController extends Controller
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
     * Lists all Input models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*
         * SELECT input.id, input.time,
         * SUM(input_detail.count) AS count
         * FROM input INNER JOIN input_detail
         * ON input.id = input_detail.input_id
         */
        $searchModel = new InputSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Input model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*
         * SELECT input.id, good.name,
         * input_detail.count FROM input
         * INNER JOIN  input_detail INNER JOIN good
         * ON input.id = input_detail.input_id
         * AND input_detail.good_id = good_id
         */
        $searchModel = new InputDetailSearch();
        $model = $this->findModel($id);
        $searchModel->input_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Input model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Input();
        $modelDetails = [new  InputDetail];

        if ($model->load(Yii::$app->request->post())) {
            $modelDetails = Input::createMultiple(InputDetail::classname());
            Input::loadMultiple($modelDetails, Yii::$app->request->post());

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
            $valid = Input::validateMultiple($modelDetails) && $valid;
            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->input_id = $model->id;
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
            'modelDetails' => (empty($modelDetails)) ? [new InputDetail] :  $modelDetails,
        ]);
    }

    /**
     * Updates an existing Input model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetails = $model->inputDetails;

        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelDetails, 'id', 'id');
            $modelDetails = Input::createMultiple(InputDetail::classname(), $modelDetails);
            Input::loadMultiple($modelDetails, Yii::$app->request->post());
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
            //$valid = Input::validateMultiple($modelDetails) && $valid;

            if($valid) {
                $transcation = Yii::$app->db->beginTransaction();
                try{
                    if($flag = $model->save(false)) {
                        if(!empty($deleteIDS)){
                            InputDetail::deleteAll(['id' => $deleteIDS]);
                        }
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->input_id = $model->id;
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
            'modelDetails' => (empty($modelDetails)) ? [new InputDetail] :  $modelDetails
        ]);
    }

    /**
     * Deletes an existing Input model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        InputDetail::deleteAll(['input_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Input model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Input the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Input::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
