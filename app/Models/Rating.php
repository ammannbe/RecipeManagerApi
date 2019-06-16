<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'recipe_id',
        'user_id',
        'rating_criterion_id',
        'comment',
        'stars',
    ];

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function ratingCriterion() {
        return $this->belongsTo('\App\Models\RatingCriterion');
    }

    public function recipe() {
        return $this->belongsTo('\App\Models\Recipe');
    }
}
