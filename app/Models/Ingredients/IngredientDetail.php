<?php

namespace App\Models\Ingredients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IngredientDetail extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'amount_max',
        'unit_id',
        'ingredient_id',
        'ingredient_detail_group_id',
        'ingredient_detail_alternate_id',
        'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the ingredient-detail's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Recipes\Recipe');
    }

    /**
     * Get the ingredient-detail's unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\Unit');
    }

    /**
     * Get the ingredient-detail's ingredient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\Ingredient');
    }

    /**
     * Get the real ingredient-detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredientDetail(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\IngredientDetail');
    }

    /**
     * Get the alternatives to this ingredient-detail's
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetails(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientDetail');
    }

    /**
     * Get the ingredient-detail's group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredientDetailGroup(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\IngredientDetailGroup');
    }

    /**
     * Get the ingredient-detail's attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredientAttributes(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Ingredients\IngredientAttribute');
    }
}
