<?php

namespace App\Policies\Users;

use App\Models\Users\User;
use App\Models\Users\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any authors.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return mixed
     */
    public function view(User $user, Author $author)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can create authors.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return mixed
     */
    public function update(User $user, Author $author)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return mixed
     */
    public function delete(User $user, Author $author)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return mixed
     */
    public function restore(User $user, Author $author)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the author.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\Author  $author
     * @return mixed
     */
    public function forceDelete(User $user, Author $author)
    {
        return $user->admin;
    }
}
