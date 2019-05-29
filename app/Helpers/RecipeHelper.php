<?php

namespace App\Helpers;

use App\Models\IngredientDetail;
use App\Models\Unit;

class RecipeHelper
{

    public static function beautifyIngredientDetail(IngredientDetail $ingredientDetail) {
        $text = '';
        if ($ingredientDetail->amount)     $text = $text.$ingredientDetail->amount;
        if ($ingredientDetail->amount &&
            $ingredientDetail->amount_max) $text = $text.'-';
        if ($ingredientDetail->amount_max) $text = $text.$ingredientDetail->amount_max;
        if ($ingredientDetail->unit)       $text = $text.' '.self::getSuitableUnit($ingredientDetail->unit, $ingredientDetail->amount);;
        if ($ingredientDetail->ingredient) $text = $text.' '.$ingredientDetail->ingredient->name;
        foreach ($ingredientDetail->preps as $prep) {
            $text = $text.', '.$prep->name;
        }
        return $text;
    }

    public static function getSuitableUnit(Unit $unit = NULL, Int $amount = NULL) {
        if (! $unit) {
            return NULL;
        }

        if ($amount > 1 && ($unit->name_plural || $unit->name_plural)) {
            return CodeHelper::any($unit->name_plural_shortcut, $unit->name_plural);
        } else {
            return CodeHelper::any($unit->name_shortcut, $unit->name);
        }
    }
}
