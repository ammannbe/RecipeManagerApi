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

    public static function time($time = NULL) {
        if (!is_null($time)) {
            $dateTime = new \DateTime($time);
            $dateTime = $dateTime->format('H:i:s');
            return $dateTime;
        } else {
            return '-';
        }
    }

    public static function shorten($text, $length = 30, $marker = '...') {
        return mb_strimwidth($text, 0, $length, $marker);
    }
}
