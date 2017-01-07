<?php

namespace humanized\lookup;

/**
 * Humanized Lookup Table Module for Yii2
 * 
 * Provides several helper tools for dealing with lookup tables - tables having two single attributes: an auto-incremented id and a unique name
 * 
 * 
 * 
 * @name Yii2 Lookup Table Module Class 
 * @version 1.0
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-lookup
 * 
 */
class Module extends \yii\base\Module
{

    public $modelRegister = [];

    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'humanized\lookup\commands';
        }

        $this->params['modelRegister'] = $this->modelRegister;
    }

}
