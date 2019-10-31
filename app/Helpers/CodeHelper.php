<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class CodeHelper
{
    public static function any($arguments)
    {
        $arguments = func_get_args();

        foreach ($arguments as $argument) {
            if ($argument) return $argument;
        }

        return end($arguments);
    }

    public static function previousUrl(string $fallback = '/'): string
    {
        $url = url()->previous();
        if ($url === url()->current()) {
            $url = url($fallback);
        }
        return $url;
    }
}
