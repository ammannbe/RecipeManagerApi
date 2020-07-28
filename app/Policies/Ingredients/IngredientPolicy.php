<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use App\Models\Ingredients\Ingredient;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientPolicy
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
     * Determine whether the user can view any ingredients.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function view(?User $user, Ingredient $ingredient): bool
    {
        $recipe = $ingredient->recipe;
        return !$recipe->cookbook_id || $user->isOwnerOf($recipe->cookbook);
    }

    /**
     * Determine whether the user can create ingredients.
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
     * Determine whether the user can update the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function update(User $user, Ingredient $ingredient): bool
    {
        return $user->isOwnerOf($ingredient);
    }

    /**
     * Determine whether the user can delete the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function delete(User $user, Ingredient $ingredient): bool
    {
        return $user->isOwnerOf($ingredient);
    }

    /**
     * Determine whether the user can restore the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function restore(User $user, Ingredient $ingredient): bool
    {
        return $user->isOwnerOf($ingredient);
    }

    /**
     * Determine whether the user can permanently delete the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function forceDelete(User $user, Ingredient $ingredient): bool
    {
        return $user->admin;
    }
}
