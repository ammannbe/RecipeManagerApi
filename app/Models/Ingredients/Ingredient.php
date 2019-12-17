<?php

namespace App\Models\Ingredients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetails@restrict'
    ];

    /**
     * Get the ingredient-detail's alternate
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
        return $this->belongsTo('\App\Models\IngredientDetailGroup', 'ingredient_detail_group_id');
    }
}
