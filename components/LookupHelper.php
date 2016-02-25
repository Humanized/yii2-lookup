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
        $class = get_called_class();
        $register = new $class();

        return $register->modelRegister;
    }

    public static function getLookupTables()
    {
        return array_keys($this->modelRegister);
    }

    public static function getTableName($lookup)
    {
        return str_replace('-', '_', $lookup);
    }

    public static function getCaller($lookup)
    {
        return $lookup;
    }

}
