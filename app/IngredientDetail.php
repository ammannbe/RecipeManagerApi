<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientDetail extends Model
{
    protected $fillable = [
        'recipe_id',
        'amount',
        'unit_id',
        'ingredient_id',
        'prep_id',
        'ingredient_detail_group_id',
        'position',
        'ingredient_detail_id'
    ];

    public function unit() {
        return $this->belongsTo('\App\Unit');
    }

    public function ingredient() {
        return $this->belongsTo('\App\Ingredient');
    }

    public function prep() {
        return $this->belongsTo('\App\Prep');
    }

    public function alternate() {
        return $this->belongsTo('\App\IngredientDetail');
    }

/*     public function recipe() {
        return $this->belongsTo('\App\Recipe', 'id');
    } */

    public function group() {
        return $this->belongsTo('\App\IngredientDetailGroup', 'ingredient_detail_group_id');
    }
}
