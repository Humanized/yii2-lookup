<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace humanized\lookup\components;

class LookupHelper {

    public $modelRegister = [];

    public static function getModelRegister()
    {
        $callerClass = get_called_class();
        $class = new $callerClass();
        return $class->modelRegister;
    }

    public static function getLookupTables()
    {
        $callerClass = get_called_class();
        $class = new $callerClass();
        return array_keys($class->modelRegister);
    }

    public static function getTableName($caller)
    {
        return str_replace('-', '_', $caller);
    }

    public static function getCaller($caller)
    {
        return $caller;
    }

    public static function getModel($caller)
    {
        $callerClass = get_called_class();
        $class = new $callerClass();
        return $class->modelRegister[$caller];
    }

}
