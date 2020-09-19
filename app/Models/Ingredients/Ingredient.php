<?php

namespace App\Models\Ingredients;

use Rutorika\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Ingredients\Ingredient
 *
 * @property int $id
 * @property int $recipe_id
 * @property float|null $amount
 * @property float|null $amount_max
 * @property int|null $unit_id
 * @property int $food_id
 * @property int|null $ingredient_group_id
 * @property int|null $ingredient_id alternate to
 * @property int|null $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Ingredients\Food $food
 * @property-read string $name
 * @property-read Ingredient|null $ingredient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\IngredientAttribute[] $ingredientAttributes
 * @property-read \App\Models\Ingredients\IngredientGroup|null $ingredientGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|Ingredient[] $ingredients
 * @property-read \App\Models\Recipes\Recipe $recipe
 * @property-read \App\Models\Ingredients\Unit|null $unit
 * @method static Builder|Ingredient inSameScope(\App\Models\Ingredients\Ingredient $ingredient)
 * @method static Builder|Ingredient newModelQuery()
 * @method static Builder|Ingredient newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ingredient onlyTrashed()
 * @method static Builder|Ingredient originalOnly()
 * @method static Builder|Ingredient query()
 * @method static Builder|Ingredient sorted()
 * @method static Builder|Ingredient whereAmount($value)
 * @method static Builder|Ingredient whereAmountMax($value)
 * @method static Builder|Ingredient whereCreatedAt($value)
 * @method static Builder|Ingredient whereDeletedAt($value)
 * @method static Builder|Ingredient whereFoodId($value)
 * @method static Builder|Ingredient whereId($value)
 * @method static Builder|Ingredient whereIngredientGroupId($value)
 * @method static Builder|Ingredient whereIngredientId($value)
 * @method static Builder|Ingredient wherePosition($value)
 * @method static Builder|Ingredient whereRecipeId($value)
 * @method static Builder|Ingredient whereUnitId($value)
 * @method static Builder|Ingredient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ingredient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ingredient withoutTrashed()
 * @mixin \Eloquent
 */
class Ingredient extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    use SortableTrait;

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
     * Group entity ordering by many fields
     *
     * @var array
     */
    protected static $sortableGroupField = [
        'recipe_id',
        'ingredient_group_id',
        'ingredient_id'
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

        $count = $this->ingredientAttributes()->count();
        if (!$count) {
            return $name;
        }

        $this->ingredientAttributes->each(function ($ingredientAttribute, $key) use ($name, $count) {
            if ($key === 0) {
                $name .= " (";
            }

            $name .= $ingredientAttribute->name;

            if ($key === $count) {
                $name .= ")";
                return;
            }

            $name .= ", ";
        });

        return $name;
    }

    /**
     * Adopt the ingredient group id from the parent, if parent is present
     *
     * This method does not automatically save the model
     *
     * @return void
     */
    public function adoptIngredientGroupFromParent(): void
    {
        if (!$this->ingredient_id) {
            return;
        }

        $this->ingredient_group_id = $this->ingredient->ingredient_group_id;
    }

    /**
     * Move the ingredient to the specified position
     *
     * If the position is NULL, append it to the end
     *
     * @param  int|null  $position
     * @return void
     */
    public function updatePosition(int $position = null): void
    {
        $query = Ingredient::inSameScope($this);

        if ($query->count() <= 1) {
            $this->update(['position' => 1]);
            return;
        }

        if ($position === null) {
            $position = $query->max('position');
        }

        $ingredientPosition = $query->wherePosition($position)->first();

        if ($position < $this->position) {
            $this->moveBefore($ingredientPosition);
            return;
        }

        $this->moveAfter($ingredientPosition);
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
     * Get all alternatives to this ingredient, ordered by the position
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\Ingredient')->orderBy('position');
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

    /**
     * Get ingredients by recipe_id, ingredient_group_id, ingredient_id
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSameScope(Builder $builder, Ingredient $ingredient): Builder
    {
        return $builder
            ->whereRecipeId($ingredient->recipe_id)
            ->whereIngredientGroupId($ingredient->ingredient_group_id)
            ->whereIngredientId($ingredient->ingredient_id);
    }
}
