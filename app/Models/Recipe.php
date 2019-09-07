<?php

namespace App\Models;

use App\Models\RatingCriterion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Recipe extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'author_id',
        'name',
        'yield_amount',
        'complexity',
        'instructions',
        'photo',
        'preparation_time',
        'user_id',
        'slug',
    ];

    /**
     * The relations that should cascade on delete
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetails',
        'ratings',
        'groups'
    ];

    /**
     * The complexity types
     *
     * @var array
     */
    private static $complexityTypes = [
        'simple',
        'normal',
        'difficult',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the recipe's author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('\App\Models\Author');
    }

    /**
     * Get the recipe's category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }

    /**
     * Get the recipe's ingredient-details
     *
     * With Unit, Ingredient, Preps, Group
     * Order by position
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetails()
    {
        return $this->hasMany('\App\Models\IngredientDetail')
            ->with(['unit', 'ingredient', 'preps', 'group'])
            ->orderBy('position');
    }

    /**
     * Get the recipe's deleted ingredient-details
     *
     * With Unit, Ingredient, Preps, Group
     * Order by position
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetailsWithTrashed()
    {
        return $this->ingredientDetails()->withTrashed();
    }

    /**
     * Get the recipe's ingredient-details
     *
     * With RatingCriterion, User
     * Get the latest one
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany('\App\Models\Rating')
            ->with(['ratingCriterion', 'user'])
            ->latest();
    }

    /**
     * Get the recipe's tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('\App\Models\Tag');
    }

    /**
     * Get the recipe's groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany('\App\Models\IngredientDetailGroup');
    }

    /**
     * Get the recipe's deleted groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupsWithTrashed()
    {
        return $this->groups()->withTrashed();
    }

    /**
     * Search recipes by instruction or recipe name
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('instructions', 'LIKE', '%' . $term . '%')
            ->orWhere('name', 'LIKE', '%' . $term . '%')
            ->with(['author', 'category']);
    }

    /**
     * Get the "best" recipes
     *
     * @param array $recipes
     * @param int $paginate = null
     * @param int $offset = 0
     *
     * @return array
     */
    public static function best($recipes, int $paginate = null, int $offset = 0)
    {
        $bestRecipes = [];
        foreach ($recipes as $key => $recipe) {
            $bestRecipes[$key] = $recipe;
            $bestRecipes[$key]['stars_avg']   = $recipe->ratings->avg('stars');
            $bestRecipes[$key]['stars_count'] = $recipe->ratings->count();
        }

        usort($bestRecipes, function ($a, $b) {
            return -($a->stars_avg <=> $b->stars_avg);
        });

        if ($paginate) {
            return array_slice($bestRecipes, $offset, $paginate);
        } else {
            return $bestRecipes;
        }
    }

    /**
     * Get translated complexity types
     */
    public static function getComplexityTypes()
    {
        $complexityTypes = self::$complexityTypes;
        self::$complexityTypes = [];
        foreach ($complexityTypes as $type) {
            self::$complexityTypes[$type] = __("forms.recipe.{$type}");
        }
        return self::$complexityTypes;
    }
}
