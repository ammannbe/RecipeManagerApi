<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientDetailGroup extends Model
{
    protected $fillable = [
        'recipe_id',
        'name'
    ];
}
