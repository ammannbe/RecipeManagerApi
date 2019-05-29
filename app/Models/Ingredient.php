<?php

namespace App\Models;

use App\Models\IngredientDetail;
use App\Helpers\CodeHelper;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name'];

    public static function searchRecipes($name) {
        return self::where('name', 'LIKE', '%'.$name.'%')
            ->with([
                'ingredientDetail.recipe',
                'ingredientDetail.recipe.author',
                'ingredientDetail.recipe.category',
            ])
            ->get();
    }

    public function ingredientDetail() {
        return $this->hasMany('\App\Models\IngredientDetail');
    }
}
