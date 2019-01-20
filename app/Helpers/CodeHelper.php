<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class CodeHelper extends Model
{
    public static function any($arguments) {
        $arguments = func_get_args();

        foreach ($arguments as $argument) {
                if ($argument) return $argument;
        }

        return end($args);
    }

    public static function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);    // replace non letter or digits by -
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
        $text = preg_replace('~[^-\w]+~', '', $text);        // remove unwanted characters
        $text = trim($text, '-');                            // trim
        $text = preg_replace('~-+~', '-', $text);            // remove duplicate -
        $text = strtolower($text);                           // lowercase

        if (empty($text)) {
            return NULL;
        }

        return $text;
    }
}
