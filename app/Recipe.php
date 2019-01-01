<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['cookbook_id', 'author_id', 'name', 'yield_amount', 'instructions', 'photo', 'preparation_time'];

    public static function setDetails(Recipe &$recipe) {
        $recipe->author;
        $recipe->cookbook;
        $recipe->categories;
        $recipe->ingredientDetails;
        $recipe->ratings;

        foreach ($recipe->ratings as $rating) {
            if ($rating->rating_criterion_id) {
                $rating->criterion = \App\RatingCriterion::find($rating->rating_criterion_id);
            }
        }

        return $recipe;
    }

    public function cookbook() {
        return $this->belongsTo('\App\Cookbook');
    }

    public function author() {
        return $this->belongsTo('\App\Author');
    }

    public function categories() {
        return $this->belongsToMany('\App\Category');
    }

    public function ingredientDetails() {
        return $this->hasMany('\App\IngredientDetail')->orderBy('position');
    }

    public function ratings() {
        return $this->hasMany('\App\Rating')->orderBy('created_at', 'DESC');
    }

    public function search($name) {
        return $this->where('instructions', 'LIKE', '%'.$name.'%')->get();
    }
}
