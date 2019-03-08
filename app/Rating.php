<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'recipe_id',
        'user_id',
        'rating_criterion_id',
        'comment'
    ];

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function ratingCriterion() {
        return $this->belongsTo('\App\RatingCriterion');
    }
}
