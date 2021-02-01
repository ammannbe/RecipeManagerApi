<?php

namespace App\Models\Ratings;

use App\Models\FilterScope;
use App\Models\Users\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Ratings\Rating
 *
 * @property int $id
 * @property int $recipe_id
 * @property int|null $user_id
 * @property int|null $author_id
 * @property int $rating_criterion_id
 * @property string $comment
 * @property int $stars
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Author|null $author
 * @property-read \App\Models\Ratings\RatingCriterion $ratingCriterion
 * @method static \Illuminate\Database\Eloquent\Builder|Rating filter(?array $filter, ?string $method = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Query\Builder|Rating onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereAuthorId($value)
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
    use FilterScope, SoftDeletes, SoftCascadeTrait, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating_criterion_id',
        'comment',
        'stars',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'ratingCriterion',
        'author',
    ];

    /**
     * Get the stars attribute
     *
     * Check that stars is not NULL
     * and not higher than config('app.max_rating_stars')
     *
     * @return int
     */
    public function getStarsAttribute(): int
    {
        $stars = $this->attributes['stars'];
        $maxStars = config('app.max_rating_stars');

        if (!$stars) {
            return 0;
        }

        if ($stars >= $maxStars) {
            return $maxStars;
        }

        return $stars;
    }

    /**
     * Get the rating's rating-criterion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratingCriterion(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Ratings\RatingCriterion');
    }

    /**
     * Get the rating's author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Users\Author');
    }
}
