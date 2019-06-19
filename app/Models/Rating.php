<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'user_id',
        'rating_criterion_id',
        'comment',
        'stars',
    ];

    /**
     * Get the rating's user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    /**
     * Get the rating's criterion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratingCriterion() {
        return $this->belongsTo('\App\Models\RatingCriterion');
    }

    /**
     * Get the rating's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe() {
        return $this->belongsTo('\App\Models\Recipe');
    }
}
