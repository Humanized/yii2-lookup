<?php

namespace humanized\lookup\controllers;

use Yii;
Use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LookupController implements the CRUD actions for ArtifactType model.
 */
class DefaultController extends Controller
{

    public $modelClass = NULL;
    private $_post = NULL;

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
        $caller = \yii::$app->getRequest()->getQueryParam('caller');
        if (!isset($caller) || $caller == '') {
            throw new \yii\base\InvalidRouteException('Module requires specification of caller parameter');
        }
        $this->_post = \yii\helpers\Inflector::classify($caller);
        $this->modelClass = $this->module->params['modelRegister'][$caller];
        return parent::beforeAction($action);
    }

    /**
     * Single interface for all CRUD Operations.
     * @return mixed
     */
    public function actionIndex($caller)
    {
        $model = new $this->modelClass();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = new $this->modelClass();
        }
        if (Yii::$app->request->post('hasEditable')) {
            $this->_update();
            return;
        }

        $searchModel = new $this->modelClass(['scenario' => \humanized\lookup\models\LookupTable::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'caller' => $caller,
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    private function _update()
    {
   
        //$post = ['ArtifactType' => $posted];
        $model = $this->findModel(Yii::$app->request->post('editableKey'));
        $model->setAttribute('name', current($_POST[$this->_post])['name']);
        $model->save();
        $output = '';
        $out = Json::encode(['output' => $output, 'message' => '']);
        echo $out;
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
        return $this->redirect(['index', 'caller' => $caller]);
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
        $class = $this->modelClass;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
