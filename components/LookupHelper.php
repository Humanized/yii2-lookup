<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace humanized\lookup\components;

class LookupHelper {

    public $register = [];

    public static function initModel()
    {
        $callerClass = get_called_class();
        return new $callerClass();
    }

    public static function getModelRegister()
    {
        $class = self::initModel();
        return array_map(function($x) {
            return $x->model;
        }, $class->register);
    }

    public static function getLookupTables()
    {
        $class = self::initModel();
        return array_keys($class->register);
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
        $class = self::initModel();
        return $class->register[$caller];
    }

}
