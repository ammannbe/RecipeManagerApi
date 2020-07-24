<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return bool
     */
    public function view(?User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return bool
     */
    public function update(User $user, Category $category): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return bool
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return bool
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return bool
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->admin;
    }
}
