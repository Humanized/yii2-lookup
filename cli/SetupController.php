<?php

namespace humanized\lookup\cli;

use yii\console\Controller;
use yii\helpers\Console;
use ReflectionClass;

/**
 * 
 * The common helper class common\components\PrivilegeHelper list all 
 * constants defining system authorisation roles and permissions.
 * 
 * This application allows 
 * 
 * 
 * 
 */
class SetupController extends Controller
{

    /**
     *
     * @var boolean Purge 
     */
    public $purge = false;
    public $classPath;
    public $cnstPrefix = 'TYPE_';
    protected $name = 'Lookup Table Synchronisation Tool';
    private $_values = [];

    /**
     * 
     * @inheritdoc
     */
    public function options($action)
    {

        $common = ['classPath'];
        $options = [];
        if ($action == 'synchronise') {
            $options[] = 'purge';
        }
        return array_merge($common, $options);
    }

    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!class_exists($this->classPath)) {
            $this->stdout('Error: ', Console::FG_RED, Console::BOLD);
            $this->stdout("Lookup table class does not exist\n");
            return false;
        }

        if (!parent::beforeAction($action)) {
            return false;
        }
        return true; // or false to not run the action
    }

    public function actionClean()
    {
        return 0;
    }

    public function actionSynchronise()
    {
        $modelClass = $this->classPath;
        $values = [];
        //Read relevant constants from class
        foreach ((new ReflectionClass($this->classPath))->getConstants() as $key => $value) {
            if (strpos($key, $this->cnstPrefix) === 0) {
                $values[] = $value;
            }
        }

        $modelClass::synchronise($values, $this->purge);
        return 0;
    }

}
