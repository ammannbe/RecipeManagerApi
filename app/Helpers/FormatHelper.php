<?php

namespace App\Helpers;

class FormatHelper
{
    public static function date(?string $date) : ?string
    {
        if ($date) {
            $dateTime = new \DateTime($date);
            $date = $dateTime->format('d.m.Y');
        }
        return $date;
    }

    public static function time(?string $time, $format = ['hours', 'minutes', 'seconds']) : string
    {
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

    public static function shorten(string $text, int $length = 30, string $marker = '...') : string
    {
        return mb_strimwidth($text, 0, $length, $marker);
    }

    public static function slugify(string $text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);    // replace non letter or digits by -
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
        $text = preg_replace('~[^-\w]+~', '', $text);        // remove unwanted characters
        $text = trim($text, '-');                            // trim
        $text = preg_replace('~-+~', '-', $text);            // remove duplicate -
        $text = strtolower($text);                           // lowercase

        if (empty($text)) {
            return null;
        } else {
            return $text;
        }
    }

    public static function generatePhotoName(string $name, string $extension) : string
    {
        $time = time();
        $slug = self::slugify($name);

        return "{$time}-{$slug}.{$extension}";
    }
}
