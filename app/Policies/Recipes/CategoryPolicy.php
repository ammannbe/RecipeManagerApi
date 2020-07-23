<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return mixed
     */
    public function view(?User $user, Category $category)
    {
        return true;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Category  $category
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        return $user->admin;
    }
}
