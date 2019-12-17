<?php

namespace App\Policies\Ratings;

use App\Models\Ratings\RatingCriterion;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingCriterionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rating criteria.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return mixed
     */
    public function view(User $user, RatingCriterion $ratingCriterion)
    {
        return true;
    }

    /**
     * Determine whether the user can create rating criteria.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return mixed
     */
    public function update(User $user, RatingCriterion $ratingCriterion)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return mixed
     */
    public function delete(User $user, RatingCriterion $ratingCriterion)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return mixed
     */
    public function restore(User $user, RatingCriterion $ratingCriterion)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return mixed
     */
    public function forceDelete(User $user, RatingCriterion $ratingCriterion)
    {
        return $user->admin;
    }
}
