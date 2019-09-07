<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Recipe;
use App\Models\IngredientDetailGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientDetailGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create ingredient detail groups.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function create(User $user, Recipe $recipe)
    {
        return ($user->id === $recipe->user_id) || ($user->is_admin);
    }

    /**
     * Determine whether the user can update the ingredient detail group.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function update(User $user, Recipe $recipe)
    {
        return ($user->id === $recipe->user_id) || ($user->is_admin);
    }

    /**
     * Determine whether the user can delete the ingredient detail group.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Recipe  $recipe
     * @return Bool
     */
    public function delete(User $user, Recipe $recipe)
    {
        return ($user->id === $recipe->user_id) || ($user->is_admin);
    }

    /**
     * Determine whether the user can restore the ingredient detail group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recipe  $recipe
     * @return mixed
     */
    public function restore(User $user, Recipe $recipe)
    {
        return ($user->id === $recipe->user_id) || ($user->is_admin);
    }
}
