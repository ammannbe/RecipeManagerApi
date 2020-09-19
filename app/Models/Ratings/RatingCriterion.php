<?php

namespace App\Models\Ratings;

use App\Models\SlugifyTrait;
use App\Models\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

/**
 * App\Models\Ratings\RatingCriterion
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion newQuery()
 * @method static \Illuminate\Database\Query\Builder|RatingCriterion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion query()
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RatingCriterion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|RatingCriterion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RatingCriterion withoutTrashed()
 * @mixin \Eloquent
 */
class RatingCriterion extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    use SlugifyTrait;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByNameScope);
    }
}
