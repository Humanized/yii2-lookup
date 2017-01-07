<?php

namespace humanized\lookup\actions;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\base\Action;

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
            $this->_updateInline();
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

    private function _updateInline()
    {
        
    }

}
