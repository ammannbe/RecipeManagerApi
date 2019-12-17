<?php

namespace App\Policies\Recipes;

use App\Models\Recipes\Tag;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tags.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return mixed
     */
    public function view(?User $user, Tag $tag)
    {
        return true;
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return mixed
     */
    public function restore(User $user, Tag $tag)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return mixed
     */
    public function forceDelete(User $user, Tag $tag)
    {
        return $user->admin;
    }
}
