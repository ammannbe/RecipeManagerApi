<?php

namespace App\Policies\Recipes;

use App\Models\Users\User;
use App\Models\Recipes\Cookbook;
use Illuminate\Auth\Access\HandlesAuthorization;

class CookbookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cookbooks.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return mixed
     */
    public function view(User $user, Cookbook $cookbook)
    {
        return $user->isAdminOrOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can create cookbooks.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return mixed
     */
    public function update(User $user, Cookbook $cookbook)
    {
        return $user->isAdminOrOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can delete the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return mixed
     */
    public function delete(User $user, Cookbook $cookbook)
    {
        return $user->isAdminOrOwnerOf($cookbook);
    }

    /**
     * Determine whether the user can restore the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return mixed
     */
    public function restore(User $user, Cookbook $cookbook)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the cookbook.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return mixed
     */
    public function forceDelete(User $user, Cookbook $cookbook)
    {
        return $user->admin;
    }
}
