<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create ratings.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function create(User $user, Recipe $recipe)
    {
        return !Rating::where([
            'recipe_id' => $recipe->id,
            'user_id' => $user->id
        ])->exists() || ($user->is_admin);
    }

    /**
     * Determine whether the user can update the rating.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Rating  $rating
     * @return Bool
     */
    public function update(User $user, Rating $rating)
    {
        return ($user->id === $rating->user_id) || ($user->is_admin);
    }

    /**
     * Determine whether the user can delete the rating.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Rating  $rating
     * @return Bool
     */
    public function delete(User $user, Rating $rating)
    {
        return ($user->id === $rating->user_id) || ($user->is_admin);
    }
}
