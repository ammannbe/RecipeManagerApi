<?php

namespace App\Policies\Ratings;

use App\Models\Ratings\Rating;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
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
     * Determine whether the user can view any ratings.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return bool
     */
    public function view(User $user, Rating $rating): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create ratings.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return bool
     */
    public function update(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can delete the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return bool
     */
    public function delete(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can restore the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return bool
     */
    public function restore(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can permanently delete the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return bool
     */
    public function forceDelete(User $user, Rating $rating): bool
    {
        return $user->admin;
    }
}
