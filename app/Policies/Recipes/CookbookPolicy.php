<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Cookbook;
use Illuminate\Auth\Access\HandlesAuthorization;

class CookbookPolicy
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
     * Determine whether the user can view any cookbooks.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function view(User $user, Cookbook $cookbook): bool
    {
        return $user->isOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can create cookbooks.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function update(User $user, Cookbook $cookbook): bool
    {
        return $user->isOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can delete the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function delete(User $user, Cookbook $cookbook): bool
    {
        return $user->isOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can restore the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function restore(User $user, Cookbook $cookbook): bool
    {
        return $user->isOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can permanently delete the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function forceDelete(User $user, Cookbook $cookbook): bool
    {
        return $user->admin;
    }
}
