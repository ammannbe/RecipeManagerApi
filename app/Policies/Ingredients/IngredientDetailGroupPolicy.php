<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Ingredients\IngredientDetailGroup;

class IngredientDetailGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredient detail groups.
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
     * Determine whether the user can view the ingredient detail group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return mixed
     */
    public function view(?User $user, IngredientDetailGroup $ingredientDetailGroup)
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient detail groups.
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
     * Determine whether the user can update the ingredient detail group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return mixed
     */
    public function update(User $user, IngredientDetailGroup $ingredientDetailGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientDetailGroup);
    }

    /**
     * Determine whether the user can delete the ingredient detail group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return mixed
     */
    public function delete(User $user, IngredientDetailGroup $ingredientDetailGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientDetailGroup);
    }

    /**
     * Determine whether the user can restore the ingredient detail group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return mixed
     */
    public function restore(User $user, IngredientDetailGroup $ingredientDetailGroup)
    {
        return $user->isAdminOrOwnerOf($ingredientDetailGroup);
    }

    /**
     * Determine whether the user can permanently delete the ingredient detail group.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return mixed
     */
    public function forceDelete(User $user, IngredientDetailGroup $ingredientDetailGroup)
    {
        return $user->admin;
    }
}
