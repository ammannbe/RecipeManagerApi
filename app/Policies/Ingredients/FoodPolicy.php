<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\Food;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
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
     * Determine whether the user can view any foods.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return bool
     */
    public function view(?User $user, Food $food): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create foods.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return bool
     */
    public function update(User $user, Food $food): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return bool
     */
    public function delete(User $user, Food $food): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return bool
     */
    public function restore(User $user, Food $food): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return bool
     */
    public function forceDelete(User $user, Food $food): bool
    {
        return $user->admin;
    }
}
