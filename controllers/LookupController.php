<?php

namespace humanized\lookup\controllers;

use Yii;
use common\models\core\ArtifactType;
use common\models\ArtifactTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LookupController implements the CRUD actions for ArtifactType model.
 */
class LookupController extends Controller {

    public $modelClass = NULL;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $caller = \yii::$app->getRequest()->getQueryParams('caller');
        if (!isset($caller) || $caller == '') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->modelClass = $this->module->params['modelRegister'][$caller];
        return parent::beforeAction($action);
    }

    /**
     * Lists all ArtifactType models.
     * @return mixed
     */
    public function actionIndex($caller)
    {
        $searchModel = new $this->modelClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'caller' => $caller,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArtifactType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($caller, $id)
    {
        return $this->render('view', [
                    'caller' => $caller,
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArtifactType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($caller)
    {
        $model = new ArtifactType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'caller' => $caller,
            ]);
        }
    }

    /**
     * Updates an existing ArtifactType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($caller, $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'caller' => $caller,
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArtifactType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($caller, $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArtifactType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArtifactType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArtifactType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
