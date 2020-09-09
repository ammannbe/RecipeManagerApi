<?php

namespace App\Models\Ingredients;

use App\Models\SlugifyTrait;
use App\Models\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Ingredients\IngredientAttribute
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read bool $can_delete
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\Ingredient[] $ingredients
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute newQuery()
 * @method static \Illuminate\Database\Query\Builder|IngredientAttribute onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|IngredientAttribute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|IngredientAttribute withoutTrashed()
 * @mixin \Eloquent
 */
class IngredientAttribute extends Model
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'can_delete',
    ];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'ingredients@restrict'
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
     * This ressource can be deleted
     *
     * @return bool
     */
    public function getCanDeleteAttribute(): bool
    {
        return !$this->ingredients()->exists();
    }

    /**
     * Get the ingredient-attribute's ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Ingredients\Ingredient');
    }
}
