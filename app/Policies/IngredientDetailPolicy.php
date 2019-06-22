<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Recipe;
use App\Models\IngredientDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientDetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create ingredient-details.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function create(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }

    /**
     * Determine whether the user can update the ingredient-detail.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function update(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }

    /**
     * Determine whether the user can delete the ingredient-detail.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function delete(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }

    /**
     * Determine whether the user can restore the ingredient detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recipe  $recipe
     * @return mixed
     */
    public function restore(User $user, Recipe $recipe)
    {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }
}
