<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientDetailGroup extends Model
{
    protected $fillable = [
        'recipe_id',
        'name'
    ];
}
