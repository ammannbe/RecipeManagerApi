<?php

namespace App\Models\Ingredients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'amount',
        'amount_max',
        'unit_id',
        'food_id',
        'ingredient_group_id',
        'ingredient_id',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'unit',
        'food',
        'ingredientAttributes',
        'ingredientGroup',
        'ingredients'
    ];

    /**
     * Generate a human-readable name (e.g. 5 - 6 Liter Tomatenmark)
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = '';
        if ($this->amount !== null) {
            $name .= "{$this->amount}";
        }
        if ($this->amount_max !== null) {
            if ($this->amount !== null) {
                $name .= ' ';
            }
            $name .= "- {$this->amount_max}";
        }
        if ($this->unit_id) {
            $name .= " {$this->unit->name}";
        }
        if ($this->food_id) {
            $name .= " {$this->food->name}";
        }
        if ($this->ingredient_attributes) {
            $this->ingredient_attributes->each(function ($ingredientAttribute, $key) use ($name) {
                $key === 0 && $name .= " (";
                $name .= $ingredientAttribute->name;
                if ($key === $this->ingredient_attributes->count()) {
                    $name .= ")";
                } else {
                    $name .= ", ";
                }
            });
        }
        return $name;
    }

    /**
     * Get the ingredient's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Recipes\Recipe');
    }

    /**
     * Get the ingredient's unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\Unit');
    }

    /**
     * Get the ingredient's food
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\Food');
    }

    /**
     * Get the "original" ingredient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\Ingredient');
    }

    /**
     * Get all alternatives to this ingredient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\Ingredient');
    }

    /**
     * Get the ingredient's group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredientGroup(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ingredients\IngredientGroup');
    }

    /**
     * Get the ingredient's attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredientAttributes(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Ingredients\IngredientAttribute');
    }

    /**
     * Get only the "original" ingredients
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOriginalOnly(Builder $builder): Builder
    {
        return $builder->whereNull('ingredient_id');
    }
}
