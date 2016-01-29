<?php

namespace app\controllers;

use Yii;
use app\models\Input;
use app\models\InputSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
		 * SELECT input.input_id, input.time,
		 * SUM(input_detail.count) AS count
		 * FROM input INNER JOIN input_detail
		 * ON input.input_id = input_detail.input_id
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
		 * SELECT input.input_id, good.name,
		 * input_detail.count FROM input
		 * INNER JOIN  input_detail INNER JOIN good
		 * ON input.input_id = input_detail.input_id
		 * AND input_detail.good_id = good_id
		 */
		$input = $this->findModel($id);
		$detail = $input->inputDetails;
        return $this->render('view', [
            'model' => $input,
			'detail' => $detail,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->input_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->input_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Input model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
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
