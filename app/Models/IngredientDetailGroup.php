<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientDetailGroup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'name'
    ];
}
