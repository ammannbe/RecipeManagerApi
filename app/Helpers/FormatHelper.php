<?php

namespace App\Helpers;

class FormatHelper
{
    public static function date(String $date = NULL) {
        if ($date) {
            $dateTime = new \DateTime($date);
            return $dateTime->format('d.m.Y');
        } else {
            return NULL;
        }
    }

    public static function time(String $time = NULL, $format = ['hours', 'minutes', 'seconds']) {
        if ($time && $format) {
            $formatString = '';
            (in_array('hours', $format))   ? $formatString .=  'H\h' : '';
            (in_array('minutes', $format)) ? $formatString .= ' i\m\i\n' : '';
            (in_array('seconds', $format)) ? $formatString .= ' s\s' : '';

            $dateTime = new \DateTime($time);
            $dateTime = $dateTime->format($formatString);
            $dateTime = preg_replace("/00h/", "", $dateTime);
            $dateTime = preg_replace("/00m/", "", $dateTime);
            $dateTime = preg_replace("/00s/", "", $dateTime);
            return $dateTime;
        } else {
            return '-';
        }
    }

    public static function shorten(String $text, Int $length = 30, String $marker = '...') {
        return mb_strimwidth($text, 0, $length, $marker);
    }

    public static function slugify(String $text = '') {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);    // replace non letter or digits by -
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
        $text = preg_replace('~[^-\w]+~', '', $text);        // remove unwanted characters
        $text = trim($text, '-');                            // trim
        $text = preg_replace('~-+~', '-', $text);            // remove duplicate -
        $text = strtolower($text);                           // lowercase

        if (empty($text)) {
            return NULL;
        } else {
            return $text;
        }
    }

    public static function generatePhotoName(String $name, String $extension) {
        $time = time();
        $slug = self::slugify($name);

        return "{$time}-{$slug}.{$extension}";
    }
}
