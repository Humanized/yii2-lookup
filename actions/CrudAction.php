<?php

namespace humanized\lookup\actions;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\helpers\Inflector;

class CrudAction extends Action
{

    public $modelClass;

    public function run()
    {

        $model = new $this->modelClass();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = new $this->modelClass();
        }
        if (Yii::$app->request->post('hasEditable')) {

            //  $this->_updateInline();
            echo Json::encode(['output' => '', 'message' => $this->_updateInline()]);
            //         echo Json::encode(['output' => '', 'message' => \yii\helpers\Inflector::classify($model->tableName())]);
            return;
        }
        $searchModel = new $this->modelClass(['scenario' => \humanized\lookup\models\LookupTable::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render('@vendor/humanized/yii2-lookup/views/default/index', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    private function _updateInline()
    {

        $msg = '';
        $modelClass = $this->modelClass;

        /**
         * /humanized/lookup/models/LookupTable
         */
        $model = $modelClass::findOne(Yii::$app->request->post('editableKey'));
        if (isset($model)) {
            $attribute = current(Yii::$app->request->post(Inflector::classify($model->tableName())))['name'];
            $model->setAttribute('name', $attribute);
            if (!$model->save()) {
                $msg = get_class($model);
            }
        }
        return $msg;
        /*
          if (isset($model)) {
          $model->setAttribute('name', current($_POST[$this->_post])['name']);
          $model->save();
          }
          $output = '';
          $out = Json::encode(['output' => $output, 'message' => '']);
          echo $out;
         * 
         */
    }

}
