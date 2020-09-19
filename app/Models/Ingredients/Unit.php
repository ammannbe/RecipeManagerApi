<?php

namespace App\Models\Ingredients;

use App\Models\SlugifyTrait;
use App\Models\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Ingredients\Unit
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $name_shortcut
 * @property string|null $name_plural
 * @property string|null $name_plural_shortcut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read bool $can_delete
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\Ingredient[] $ingredients
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Query\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereNamePlural($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereNamePluralShortcut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereNameShortcut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Unit withoutTrashed()
 * @mixin \Eloquent
 */
class Unit extends Model
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
        'name_shortcut',
        'name_plural',
        'name_plural_shortcut'
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
     * Get the unit's ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\Ingredient');
    }
}
