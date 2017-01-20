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
        $modelClass = $this->modelClass;
        //Model Creation
        $model = new $modelClass;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = new $this->modelClass();
        }
        //Inline Model Update
        if (Yii::$app->request->post('hasEditable')) {
            echo Json::encode(['output' => '', 'message' => $this->_updateInline()]);
            return;
        }

        //Inline Model Update
        if (Yii::$app->request->post('hasDeletable')) {
            $modelClass::deleteAll(['id' => Yii::$app->request->post('deletableKey')]);
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
        $model = $modelClass::findOne(Yii::$app->request->post('editableKey'));
        if (isset($model)) {
            $attribute = current(Yii::$app->request->post(Inflector::classify($model->tableName())))['name'];
            $model->setAttribute('name', $attribute);
            if (!$model->save()) {
                $msg = get_class($model);
            }
        }
        return $msg;
    }

}
