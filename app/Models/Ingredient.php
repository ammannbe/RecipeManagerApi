<?php

namespace App\Models;

use App\Models\IngredientDetail;
use App\Helpers\CodeHelper;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * Search recipes by ingredient name
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchRecipes($name) {
        return self::where('name', 'LIKE', '%'.$name.'%')
            ->with([
                'ingredientDetail.recipe',
                'ingredientDetail.recipe.author',
                'ingredientDetail.recipe.category',
            ])
            ->get();
    }

    /**
     * Get the ingredient's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetail() {
        return $this->hasMany('\App\Models\IngredientDetail');
    }
}
