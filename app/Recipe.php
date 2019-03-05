<?php

namespace App;

use App\RatingCriterion;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'cookbook_id',
        'author_id',
        'name',
        'yield_amount',
        'instructions',
        'photo',
        'preparation_time',
        'user_id'
    ];

    public static function setDetails(Recipe &$recipe) {
        $recipe->author;
        $recipe->cookbook;
        $recipe->category;
        $recipe->ingredientDetails;
        $recipe->ratings;

        foreach ($recipe->ratings as $rating) {
            if ($rating->rating_criterion_id) {
                $rating->criterion = RatingCriterion::find($rating->rating_criterion_id);
            }
        }

        foreach ($recipe->ingredientDetails as $ingredientDetail) {
            $ingredientDetail->unit;
            $ingredientDetail->ingredient;
            $ingredientDetail->prep;
            $ingredientDetail->group;
        }

        return $recipe;
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
        return $this->hasMany('\App\IngredientDetail')->orderBy('position');
    }

    public function ratings() {
        return $this->hasMany('\App\Rating')->orderBy('created_at', 'DESC');
    }

    public function search($term) {
        return $this->where('instructions', 'LIKE', '%'.$term.'%')
            ->orWhere('name', 'LIKE', '%'.$term.'%')
            ->get();
    }
}
