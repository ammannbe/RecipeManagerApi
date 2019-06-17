<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the author.
     *
     * @param  \App\Models\User  $user
     * @return Bool
     */
    public function update(User $user) {
        return ($user->isAdmin());
    }

    /**
     * Determine whether the user can delete the author.
     *
     * @param  \App\Models\User  $user
     * @return Bool
     */
    public function delete(User $user) {
        return ($user->isAdmin());
    }
}
