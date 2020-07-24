<?php

namespace App\Policies\Recipes;

use App\Models\Recipes\Tag;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
     * Determine whether the user can view any tags.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return bool
     */
    public function view(?User $user, Tag $tag): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return bool
     */
    public function update(User $user, Tag $tag): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return bool
     */
    public function delete(User $user, Tag $tag): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return bool
     */
    public function restore(User $user, Tag $tag): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the tag.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Recipes\Tag  $tag
     * @return bool
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return $user->admin;
    }
}
