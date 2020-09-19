<?php

namespace App\Models\Ratings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ratings\Rating
 *
 * @property int $id
 * @property int $recipe_id
 * @property int|null $user_id
 * @property int $rating_criterion_id
 * @property string $comment
 * @property int|null $stars
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Ratings\RatingCriterion $ratingCriterion
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Query\Builder|Rating onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereRatingCriterionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Rating withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rating withoutTrashed()
 * @mixin \Eloquent
 */
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
        'ratingCriterion'
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
