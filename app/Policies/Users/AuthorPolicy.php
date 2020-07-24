<?php

namespace App\Policies\Users;

use App\Models\Users\User;
use App\Models\Users\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
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
     * Determine whether the user can view any authors.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return bool
     */
    public function view(User $user, Author $author): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can create authors.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return bool
     */
    public function update(User $user, Author $author): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return bool
     */
    public function delete(User $user, Author $author): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return bool
     */
    public function restore(User $user, Author $author): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return bool
     */
    public function forceDelete(User $user, Author $author): bool
    {
        return $user->admin;
    }
}
