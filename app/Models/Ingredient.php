<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $name): Builder
    {
        return $query->where('name', 'LIKE', '%' . $name . '%')
            ->with([
                'ingredientDetail.recipe',
                'ingredientDetail.recipe.author',
                'ingredientDetail.recipe.category',
            ]);
    }

    /**
     * Get the ingredient's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetails() : HasMany
    {
        return $this->hasMany('\App\Models\IngredientDetail');
    }
}
