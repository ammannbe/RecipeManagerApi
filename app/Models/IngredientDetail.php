<?php

namespace App\Models;

use App\Helpers\RecipeHelper;
use Illuminate\Database\Eloquent\Model;

class IngredientDetail extends Model
{
    protected $fillable = [
        'recipe_id',
        'amount',
        'unit_id',
        'ingredient_id',
        'ingredient_detail_group_id',
        'position',
        'ingredient_detail_id'
    ];

    public function beautify() {
        $text = '';
        if ($this->amount)     $text = $text.$this->amount;
        if ($this->amount &&
            $this->amount_max) $text = $text.'-';
        if ($this->amount_max) $text = $text.$this->amount_max;
        if ($this->unit)       $text = $text.' '.RecipeHelper::getSuitableUnit($this->unit, $this->amount);;
        if ($this->ingredient) $text = $text.' '.$this->ingredient->name;
        foreach ($this->preps as $prep) {
            $text = $text.', '.$prep->name;
        }
        return $text;
    }

    public static function reorder($recipe_id) {
        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe_id)
            ->orderBy('ingredient_detail_group_id')
            ->orderBy('position')
            ->get();
        $lastIngredientDetail = NULL;
        $i = 1;
        $j = 1;

        foreach ($ingredientDetails as $ingredientDetail) {
            if ($ingredientDetail->ingredient_detail_id) {
                $ingredientDetail->position = 1;
            } elseif ($ingredientDetail->ingredient_detail_group_id) {
                if ($ingredientDetail != $lastIngredientDetail) {
                    $j = 1;
                }
                $ingredientDetail->position = $j;
                $j++;
            } else {
                $ingredientDetail->position = $i;
                $i++;
            }
            $ingredientDetail->save();

            $lastIngredientDetail = $ingredientDetail;
        }
    }

    public function ingredientDetail() {
        return $this->hasMany('\App\Models\IngredientDetail');
    }

    public function recipe() {
        return $this->belongsTo('\App\Models\Recipe');
    }

    public function unit() {
        return $this->belongsTo('\App\Models\Unit');
    }

    public function ingredient() {
        return $this->belongsTo('\App\Models\Ingredient');
    }

    public function preps() {
        return $this->belongsToMany('\App\Models\Prep');
    }

    public function group() {
        return $this->belongsTo('\App\Models\IngredientDetailGroup', 'ingredient_detail_group_id');
    }
}
