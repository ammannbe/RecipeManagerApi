<?php

namespace App\Models\Ratings;

use App\Models\SlugifyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

/**
 * @property  int  $author_id
 */
class RatingCriterion extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    use SlugifyTrait;
}
