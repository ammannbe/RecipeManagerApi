<?php

namespace App\Helpers;

class FormHelper
{
    public static function group(String $group) {
        return '<div class="group '.$group.'">';
    }

    public static function groups(Array $groups) {
        $html = '';
        foreach ($groups as $group) {
            $html .= self::group($group);
        }
        return $html;
    }

    public static function close(Int $number = 1) {
        $html = '';
        for ($i = 0; $i < $number; $i++) {
            $html .= '</div>';
        }
        return $html;
    }

    public static function jsDropdown(Array $items) {
        $html  = '<button class="arrow-down"></button>';
        $html .= '<ul class="hidden js-dropdown">';
        foreach ($items as $item) {
            $html .= '<li>'.$item.'</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function switch(String $class = 'admin') {
        return
            '<label class="switch '.$class.'">' .
                \Form::checkbox(NULL, NULL, TRUE) .
                '<span class="slider round"></span>' .
            '</label>';
    }

    public static function backButton(String $text, Array $properties = [], String $fallbackUri = '/') {
        if (!isset($properties['href'])) {
            $properties['href'] = CodeHelper::previousUrl($fallbackUri);
        }

        $propertiesText = '';
        foreach ($properties as $key => $property) {
            $propertiesText .= " {$key}=\"{$property}\"";
        }

        return "<a {$propertiesText}>{$text}</a>";
    }

    public static function rating(Int $default = NULL, Int $number = 5) {
        $html = '<span class="stars">';
        for ($i = $number; $i > 0; $i--) {
            $html .= '<input id="star'.$i.'" type="radio" name="stars" value="'.$i.'"'.($default === $i ? 'checked' : NULL).'>';
            $html .= '<label for="star'.$i.'">'.$i.'</label>';
        }
        $html .= '</span>';

        return $html;
    }
}
