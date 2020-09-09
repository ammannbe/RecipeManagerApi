<?php

namespace App\Models\Recipes;

use App\Models\SlugifyTrait;
use App\Models\OrderByNameScope;
use App\Models\Users\AdminOrOwnerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Recipes\Cookbook
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $user_id
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipes\Recipe[] $recipes
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cookbook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cookbook whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Cookbook withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cookbook withoutTrashed()
 * @mixin \Eloquent
 */
class Cookbook extends Model
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
        // Only for CookbookFactory
        'user_id',
        'author_id',
    ];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'recipes'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminOrOwnerScope);
        static::addGlobalScope(new OrderByNameScope);
    }

    /**
     * Get the category's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes(): HasMany
    {
        return $this->hasMany('\App\Models\Recipes\Recipe');
    }
}
