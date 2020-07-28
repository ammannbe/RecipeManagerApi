<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
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
     * Determine whether the user can view any recipes.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function view(?User $user, Recipe $recipe): bool
    {
        return !$recipe->cookbook_id || $user->isOwnerOf($recipe->cookbook);
    }

    /**
     * Determine whether the user can create recipes.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->isOwnerOf($recipe);
    }

    /**
     * Determine whether the user can delete the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->isOwnerOf($recipe);
    }

    /**
     * Determine whether the user can restore the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function restore(User $user, Recipe $recipe): bool
    {
        return $user->isOwnerOf($recipe);
    }

    /**
     * Determine whether the user can permanently delete the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function forceDelete(User $user, Recipe $recipe): bool
    {
        return $user->admin;
    }
}
