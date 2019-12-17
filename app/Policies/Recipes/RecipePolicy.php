<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any recipes.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function view(?User $user, Recipe $recipe)
    {
        return true;
    }

    /**
     * Determine whether the user can create recipes.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function update(User $user, Recipe $recipe)
    {
        return $user->isAdminOrOwnerOf($recipe);
    }

    /**
     * Determine whether the user can delete the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function delete(User $user, Recipe $recipe)
    {
        return $user->isAdminOrOwnerOf($recipe);
    }

    /**
     * Determine whether the user can restore the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function restore(User $user, Recipe $recipe)
    {
        return $user->isAdminOrOwnerOf($recipe);
    }

    /**
     * Determine whether the user can permanently delete the recipe.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function forceDelete(User $user, Recipe $recipe)
    {
        return $user->admin;
    }
}
