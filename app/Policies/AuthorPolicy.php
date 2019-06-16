<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    // TODO: connect author and user, allow user to delete his author
    public function update(User $user) {
        return ($user->isAdmin());
    }

    // TODO: connect author and user, allow user to delete his author
    public function delete(User $user) {
        return ($user->isAdmin());
    }
}
