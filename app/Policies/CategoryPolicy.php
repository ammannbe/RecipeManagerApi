<?php

namespace App\Policies;

use App\User;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function update(User $user) {
        return ($user->isAdmin());
    }

    public function delete(User $user) {
        return ($user->isAdmin());
    }
}
