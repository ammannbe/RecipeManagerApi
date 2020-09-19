<?php

namespace App\Models\Ingredients;

use App\Models\SlugifyTrait;
use App\Models\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ingredients\IngredientGroup
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\Ingredient[] $ingredients
 * @property-read \App\Models\Recipes\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|IngredientGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|IngredientGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|IngredientGroup withoutTrashed()
 * @mixin \Eloquent
 */
class IngredientGroup extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    use SlugifyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'ingredients',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByNameScope);
    }

    /**
     * Get the ingredient-group's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Recipes\Recipe');
    }

    /**
     * Get the ingredient-group's ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\Ingredient');
    }
}
