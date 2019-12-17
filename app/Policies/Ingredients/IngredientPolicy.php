<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\Ingredient;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredients.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return mixed
     */
    public function view(?User $user, Ingredient $ingredient)
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredients.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return mixed
     */
    public function update(User $user, Ingredient $ingredient)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return mixed
     */
    public function delete(User $user, Ingredient $ingredient)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return mixed
     */
    public function restore(User $user, Ingredient $ingredient)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the ingredient.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return mixed
     */
    public function forceDelete(User $user, Ingredient $ingredient)
    {
        return $user->admin;
    }
}
