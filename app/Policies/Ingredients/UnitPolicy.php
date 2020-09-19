<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\Unit;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
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
     * Determine whether the user can view any units.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return bool
     */
    public function view(?User $user, Unit $unit): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create units.
     *
     * @param  \App\Models\Users\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return bool
     */
    public function update(User $user, Unit $unit): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return bool
     */
    public function delete(User $user, Unit $unit): bool
    {
        return $user->admin
            && $unit->can_delete;
    }

    /**
     * Determine whether the user can restore the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return bool
     */
    public function restore(User $user, Unit $unit): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return bool
     */
    public function forceDelete(User $user, Unit $unit): bool
    {
        return $user->admin;
    }
}
