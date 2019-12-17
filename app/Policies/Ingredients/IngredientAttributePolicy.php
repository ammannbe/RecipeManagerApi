<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\IngredientAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientAttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredient-attributes.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return mixed
     */
    public function view(?User $user, IngredientAttribute $ingredientAttribute)
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient-attributes.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return mixed
     */
    public function update(User $user, IngredientAttribute $ingredientAttribute)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return mixed
     */
    public function delete(User $user, IngredientAttribute $ingredientAttribute)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return mixed
     */
    public function restore(User $user, IngredientAttribute $ingredientAttribute)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return mixed
     */
    public function forceDelete(User $user, IngredientAttribute $ingredientAttribute)
    {
        return $user->admin;
    }
}
