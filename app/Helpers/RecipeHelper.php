<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\IngredientDetail;
use App\Unit;

class RecipeHelper extends Model
{

    public static function beautifyIngredientDetail(IngredientDetail $ingredientDetail) {
        $text = '';
        if ($ingredientDetail->amount)     $text = $text.$ingredientDetail->amount;
        if ($ingredientDetail->unit)       $text = $text.' '.self::getSuitableUnit($ingredientDetail->unit, $ingredientDetail->amount);;
        if ($ingredientDetail->ingredient) $text = $text.' '.$ingredientDetail->ingredient->name;
        if ($ingredientDetail->prep)       $text = $text.', '.$ingredientDetail->prep->name;
        return $text;
    }

    public static function getSuitableUnit(Unit $unit = NULL, Int $amount = NULL) {
        if ($unit) {
            if ($amount > 1 && ($unit->name_plural || $unit->name_plural)) {
                return CodeHelper::any($unit->name_plural_shortcut, $unit->name_plural);
            } else {
                return CodeHelper::any($unit->name_shortcut, $unit->name);
            }
        } else {
            return NULL;
        }
    }
}
