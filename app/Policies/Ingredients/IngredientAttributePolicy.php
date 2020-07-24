<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\IngredientAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientAttributePolicy
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
     * Determine whether the user can view any ingredient-attributes.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return bool
     */
    public function view(?User $user, IngredientAttribute $ingredientAttribute): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create ingredient-attributes.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return bool
     */
    public function update(User $user, IngredientAttribute $ingredientAttribute): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return bool
     */
    public function delete(User $user, IngredientAttribute $ingredientAttribute): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return bool
     */
    public function restore(User $user, IngredientAttribute $ingredientAttribute): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the ingredient-attribute.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return bool
     */
    public function forceDelete(User $user, IngredientAttribute $ingredientAttribute): bool
    {
        return $user->admin;
    }
}
