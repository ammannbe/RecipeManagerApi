<?php

namespace App\Models\Recipes;

use App\Models\FilterScope;
use App\Models\SlugifyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use FilterScope;
    use SoftDeletes;
    use SoftCascadeTrait;
    use SlugifyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cookbook_id',
        'category_id',
        'name',
        'yield_amount',
        'complexity',
        'instructions',
        'photo',
        'preparation_time',
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
     * The relations that should cascade on delete
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetails',
        'ingredientDetailGroups',
        'ratings',
    ];

    /**
     * Possible values for the complexity_types enum field
     *
     * @var array
     */
    public const COMPLEXITY_TYPES = [
        'simple',
        'normal',
        'difficult',
    ];

    /**
     * Get the recipe's tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Recipes\Tag');
    }

    /**
     * Get the recipe's ingredientDetails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetails(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientDetail')
            ->with(['unit', 'ingredient', 'ingredientAttributes', 'ingredientDetailGroup']);
    }

    /**
     * Get the recipe's ingredientDetailGroups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetailGroups(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientDetailGroup');
    }

    /**
     * Get the recipe's ratings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany('\App\Models\Recipes\Ratings')
            ->with(['ratingCriterion']);
    }
}
