<?php

namespace App\Models\Ratings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'rating_criterion'
    ];

    /**
     * Get the rating's rating-criterion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratingCriterion(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ratings\RatingCriterion');
    }
}
