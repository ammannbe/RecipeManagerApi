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
}
