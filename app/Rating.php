<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['recipe_id', 'user_id', 'rating_criterion_id', 'comment'];

    public function criterion() {
        return $this->belongsTo('\App\RatingCriterion', 'rating_criterion_id');
    }
}
