<?php

namespace App\Policies\Ratings;

use App\Models\Ratings\Rating;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ratings.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return mixed
     */
    public function view(User $user, Rating $rating)
    {
        return true;
    }

    /**
     * Determine whether the user can create ratings.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return mixed
     */
    public function update(User $user, Rating $rating)
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can delete the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return mixed
     */
    public function delete(User $user, Rating $rating)
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can restore the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return mixed
     */
    public function restore(User $user, Rating $rating)
    {
        return $user->id === $rating->user_id;
    }

    /**
     * Determine whether the user can permanently delete the rating.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ratings\Rating  $rating
     * @return mixed
     */
    public function forceDelete(User $user, Rating $rating)
    {
        return $user->admin;
    }
}
