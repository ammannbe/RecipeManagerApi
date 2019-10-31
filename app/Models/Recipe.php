<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function author(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Author');
    }

    /**
     * Get the recipe's category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
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
    public function ingredientDetails(): HasMany
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
    public function ingredientDetailsWithTrashed(): HasMany
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
    public function ratings(): HasMany
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
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Tag');
    }

    /**
     * Get the recipe's groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany('\App\Models\IngredientDetailGroup');
    }

    /**
     * Get the recipe's deleted groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupsWithTrashed(): HasMany
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
     * Reorder the ingredient-details' position of this recipe
     *
     * @return void
     */
    public function reorder(): void
    {
        $grouped = $this->ingredientDetails()
            ->orderBy('ingredient_detail_group_id')
            ->orderBy('position')
            ->get()
            ->groupBy('ingredient_detail_group_id');

        foreach ($grouped as $ingredientDetails) {
            $i = 1;
            foreach ($ingredientDetails as $ingredientDetail) {
                $position = 1;
                if (!$ingredientDetail->ingredient_detail_id) {
                    $position = $i++;
                }
                $ingredientDetail->position = $position;
            }
        }
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
     *
     * @return array
     */
    public static function getComplexityTypes()
    {
        $complexityTypes = [];
        foreach (config('recipes.complexity_types') as $type) {
            $complexityTypes[$type] = __("forms.recipe.{$type}");
        }
        return $complexityTypes;
    }
}
