<?php

namespace App\Helpers;

class FormHelper
{
    public static function group(string $group) : string
    {
        return '<div class="group '.$group.'">';
    }

    public static function groups(array $groups) : string
    {
        $html = '';
        foreach ($groups as $group) {
            $html .= self::group($group);
        }
        return $html;
    }

    public static function close(int $number = 1) : string
    {
        $html = '';
        for ($i = 0; $i < $number; $i++) {
            $html .= '</div>';
        }
        return $html;
    }

    public static function switch(string $class = 'admin') : string
    {
        return
            '<label class="switch '.$class.'">' .
                \Form::checkbox(null, null, true) .
                '<span class="slider round"></span>' .
            '</label>';
    }

    public static function backButton(string $text, array $properties = [], string $fallbackUri = '/') : string
    {
        if (!isset($properties['href'])) {
            $properties['href'] = CodeHelper::previousUrl($fallbackUri);
        }

        $propertiesText = '';
        foreach ($properties as $key => $property) {
            $propertiesText .= " {$key}=\"{$property}\"";
        }

        return "<a {$propertiesText}>{$text}</a>";
    }

    public static function rating(int $default = null, int $number = 5) {
        $html = '<span class="stars">';
        for ($i = $number; $i > 0; $i--) {
            $html .= '<input id="star'.$i.'" type="radio" name="stars" value="'.$i.'"'.($default === $i ? 'checked' : null).'>';
            $html .= '<label for="star'.$i.'">'.$i.'</label>';
        }
        $html .= '</span>';

        return $html;
    }
}
