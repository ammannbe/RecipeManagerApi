<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\Food;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any foods.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return mixed
     */
    public function view(?User $user, Food $food)
    {
        return true;
    }

    /**
     * Determine whether the user can create foods.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return mixed
     */
    public function update(User $user, Food $food)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return mixed
     */
    public function delete(User $user, Food $food)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return mixed
     */
    public function restore(User $user, Food $food)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the food.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Food  $food
     * @return mixed
     */
    public function forceDelete(User $user, Food $food)
    {
        return $user->admin;
    }
}
