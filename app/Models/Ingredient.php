<?php

namespace App\Models;

use App\Helpers\CodeHelper;
use App\Models\IngredientDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Ingredient extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetail@restrict'
    ];

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
