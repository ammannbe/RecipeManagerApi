<?php

namespace App\Helpers;

class FormatHelper
{
    public static function date($date = NULL) {
        if (!is_null($date)) {
            $dateTime = new \DateTime($date);
            return $dateTime->format('d.m.Y');
        } else {
            return '-';
        }
    }

    public static function time($time = NULL, $format = ['hours', 'minutes', 'seconds']) {
        if ($time && $format) {
            $formatString = '';
            (in_array('hours', $format))   ? $formatString .=  'H\h' : '';
            (in_array('minutes', $format)) ? $formatString .= ' i\m\i\n' : '';
            (in_array('seconds', $format)) ? $formatString .= ' s\s' : '';
            $dateTime = new \DateTime($time);
            $dateTime = $dateTime->format($formatString);
            return $dateTime;
        } else {
            return '-';
        }
    }

    public static function shorten($text, $length = 30, $marker = '...') {
        return mb_strimwidth($text, 0, $length, $marker);
    }
}
