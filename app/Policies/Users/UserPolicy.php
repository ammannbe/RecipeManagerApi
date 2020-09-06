<?php

namespace App\Policies\Users;

use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Users\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
