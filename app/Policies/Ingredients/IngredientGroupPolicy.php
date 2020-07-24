<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use App\Models\Ingredients\IngredientGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientGroupPolicy
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
    public function viewAny(?User $user, Recipe $recipe): bool
    {
        return !$recipe->cookbook_id || $user->isOwnerOf($recipe->cookbook);
    }

    /**
     * Determine whether the user can view the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function view(?User $user, IngredientGroup $ingredientGroup): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient groups.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function create(User $user, Recipe $recipe): bool
    {
        return $user->isOwnerOf($recipe);
    }

    /**
     * Determine whether the user can update the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function update(User $user, IngredientGroup $ingredientGroup): bool
    {
        return $user->isOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can delete the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function delete(User $user, IngredientGroup $ingredientGroup): bool
    {
        return $user->isOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can restore the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function restore(User $user, IngredientGroup $ingredientGroup): bool
    {
        return $user->isOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can permanently delete the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function forceDelete(User $user, IngredientGroup $ingredientGroup): bool
    {
        return $user->admin;
    }
}
