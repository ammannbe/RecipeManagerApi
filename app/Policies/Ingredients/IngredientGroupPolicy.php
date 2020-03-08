<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Ingredients\IngredientGroup;

class IngredientGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredient groups.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function viewAny(?User $user, Recipe $recipe)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return mixed
     */
    public function view(?User $user, IngredientGroup $ingredientGroup)
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient groups.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return mixed
     */
    public function create(User $user, Recipe $recipe)
    {
        return $user->isAdminOrOwnerOf($recipe);
    }

    /**
     * Determine whether the user can update the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return mixed
     */
    public function update(User $user, IngredientGroup $ingredientGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can delete the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return mixed
     */
    public function delete(User $user, IngredientGroup $ingredientGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can restore the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return mixed
     */
    public function restore(User $user, IngredientGroup $ingredientGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientGroup);
    }

    /**
     * Determine whether the user can permanently delete the ingredient group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return mixed
     */
    public function forceDelete(User $user, IngredientGroup $ingredientGroup)
    {
        return $user->admin;
    }
}
