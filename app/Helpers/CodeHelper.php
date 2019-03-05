<?php

namespace App\Helpers;

class CodeHelper
{
    public static function any($arguments) {
        $arguments = func_get_args();

        foreach ($arguments as $argument) {
                if ($argument) return $argument;
        }

        return end($args);
    }

    public static function weakArrayTypeCheck(Array $array, String $index) {
        if (!isset($array[$index]))  return NULL;
        if (empty($array[$index]))   return NULL;
        if (!$array[$index])         return NULL;
        if ($array[$index] == 0)     return NULL;

        return $array[$index];
    }
}
