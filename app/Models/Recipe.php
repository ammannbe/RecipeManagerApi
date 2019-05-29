<?php

namespace App\Models;

use App\Models\RatingCriterion;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'name',
        'yield_amount',
        'instructions',
        'photo',
        'preparation_time',
        'user_id',
        'slug',
    ];

    public function getRouteKeyName() {
        return 'slug';
    }

    public function author() {
        return $this->belongsTo('\App\Models\Author');
    }

    public function category() {
        return $this->belongsTo('\App\Models\Category');
    }

    public function ingredientDetails() {
        return $this->hasMany('\App\Models\IngredientDetail')
            ->with(['unit', 'ingredient', 'preps', 'group'])
            ->orderBy('position');
    }

    public function ratings() {
        return $this->hasMany('\App\Models\Rating')
            ->with(['ratingCriterion', 'user'])
            ->latest();
    }

    public function tags() {
        return $this->belongsToMany('\App\Models\Tag');
    }

    public function searchRecipes($term) {
        return $this->where('instructions', 'LIKE', '%'.$term.'%')
            ->orWhere('name', 'LIKE', '%'.$term.'%')
            ->with(['author', 'category'])
            ->get();
    }

    public static function best($recipes, Int $paginate = NULL, Int $offset = 0) {
        foreach ($recipes as $key => $recipe) {
            $bestRecipes[$key] = $recipe;
            $bestRecipes[$key]['stars_avg']   = $recipe->ratings->avg('stars');
            $bestRecipes[$key]['stars_count'] = $recipe->ratings->count();
        }

        usort($bestRecipes, function($a, $b) {
            return -($a->stars_avg <=> $b->stars_avg);
        });

        if ($paginate) {
            return array_slice($bestRecipes, $offset, $paginate);
        } else {
            return $bestRecipes;
        }
    }
}
