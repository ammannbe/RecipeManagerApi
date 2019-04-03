<?php

namespace App;

use App\RatingCriterion;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'cookbook_id',
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

    public function cookbook() {
        return $this->belongsTo('\App\Cookbook');
    }

    public function author() {
        return $this->belongsTo('\App\Author');
    }

    public function category() {
        return $this->belongsTo('\App\Category');
    }

    public function ingredientDetails() {
        return $this->hasMany('\App\IngredientDetail')
            ->with(['unit', 'ingredient', 'preps', 'group'])
            ->orderBy('position');
    }

    public function ratings() {
        return $this->hasMany('\App\Rating')
            ->with(['ratingCriterion', 'user'])
            ->latest();
    }

    public function searchRecipes($term) {
        return $this->where('instructions', 'LIKE', '%'.$term.'%')
            ->orWhere('name', 'LIKE', '%'.$term.'%')
            ->with(['author', 'category'])
            ->get();
    }

    public static function best($recipes, Int $paginate = NULL) {
        foreach ($recipes as $key => $recipe) {
            $bestRecipes[$key] = $recipe;
            $bestRecipes[$key]['stars_avg']   = $recipe->ratings()->avg('stars');
            $bestRecipes[$key]['stars_count'] = $recipe->ratings()->count();
        }

        usort($bestRecipes, function($a, $b) {
            return -($a->stars_avg <=> $b->stars_avg);
        });

        if ($paginate) {
            return array_slice($bestRecipes, 0, $paginate);
        } else {
            return $bestRecipes;
        }
    }
}
