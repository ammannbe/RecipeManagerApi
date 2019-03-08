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
        'user_id'
    ];

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
            ->with(['unit', 'ingredient', 'prep', 'group'])
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
}
