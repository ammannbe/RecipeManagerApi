<?php

namespace App\Policies\Ratings;

use App\Models\Ratings\RatingCriterion;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingCriterionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if this user is an admin and skip other validations
     *
     * @param  \App\Models\Users\User  $user
     * @param  mixed  $ability
     * @return bool|void
     */
    public function before(User $user, $ability)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any rating criteria.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return bool
     */
    public function view(User $user, RatingCriterion $ratingCriterion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create rating criteria.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return bool
     */
    public function update(User $user, RatingCriterion $ratingCriterion): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return bool
     */
    public function delete(User $user, RatingCriterion $ratingCriterion): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return bool
     */
    public function restore(User $user, RatingCriterion $ratingCriterion): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the rating criterion.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return bool
     */
    public function forceDelete(User $user, RatingCriterion $ratingCriterion): bool
    {
        return $user->admin;
    }
}
