<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Recipes\Recipe;
use App\Models\Ingredients\IngredientDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientDetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredient details.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient detail.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return mixed
     */
    public function view(?User $user, IngredientDetail $ingredientDetail)
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient details.
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
     * Determine whether the user can update the ingredient detail.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return mixed
     */
    public function update(User $user, IngredientDetail $ingredientDetail)
    {
        return $user->isAdminOrOwnerOf($ingredientDetail);
    }

    /**
     * Determine whether the user can delete the ingredient detail.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return mixed
     */
    public function delete(User $user, IngredientDetail $ingredientDetail)
    {
        return $user->isAdminOrOwnerOf($ingredientDetail);
    }

    /**
     * Determine whether the user can restore the ingredient detail.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return mixed
     */
    public function restore(User $user, IngredientDetail $ingredientDetail)
    {
        return $user->isAdminOrOwnerOf($ingredientDetail);
    }

    /**
     * Determine whether the user can permanently delete the ingredient detail.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return mixed
     */
    public function forceDelete(User $user, IngredientDetail $ingredientDetail)
    {
        return $user->admin;
    }
}
