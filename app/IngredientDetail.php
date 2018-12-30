<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientDetail extends Model
{
    protected $fillable = ['recipe_id', 'amount', 'unit_id', 'ingredient_id', 'prep_id', 'position', 'ingredient_detail_id'] ;

    public function units() {
        return $this->belongsTo('\App\Unit');
    }

    public function ingredients() {
        return $this->belongsTo('\App\Ingredient');
    }

    public function preps() {
        return $this->belongsTo('\App\Prep');
    }

    public function parent() {
        return $this->belongsTo('\App\IngredientDetail');
    }

    public function recipes() {
        return $this->belongsTo('\App\Recipe', 'id');
    }
}
