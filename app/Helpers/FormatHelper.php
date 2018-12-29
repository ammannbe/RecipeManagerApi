<?php

namespace App\Helpers;

class FormatHelper
{
    public static function date($date) {
        $dateTime = new \DateTime($date);
        return $dateTime->format('d.m.Y');
    }

    public static function time($time) {
        $dateTime = new \DateTime($time);
        $dateTime = $dateTime->format('H:i:s');
        return $dateTime;
    }

    public static function shorten($text, $length = 30, $marker = '...') {
        return mb_strimwidth($text, 0, $length, $marker);
    }
}
