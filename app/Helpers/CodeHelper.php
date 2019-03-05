<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

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

    public static function getCollectionProperty(Collection $collections, String $property = 'name') {
        $array = [];
        foreach ($collections as $collection) {
            $array[$collection->id] = $collection->{$property};
        }
        return $array;
    }

    public static function getObjectProperty(String $model, String $value = NULL, String $property = 'id', String $where = 'name') {
        $class = '\\App\\'.$model;
        $object = $class::where($where, $value)->first();
        if ($object) {
            return $object->{$property};
        } else {
            return NULL;
        }
    }
}
