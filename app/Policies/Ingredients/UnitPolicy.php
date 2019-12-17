<?php

namespace App\Policies\Ingredients;

use App\Models\Users\User;
use App\Models\Ingredients\Unit;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any units.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return mixed
     */
    public function view(?User $user, Unit $unit)
    {
        return true;
    }

    /**
     * Determine whether the user can create units.
     *
     * @param  \App\Models\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return mixed
     */
    public function update(User $user, Unit $unit)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return mixed
     */
    public function delete(User $user, Unit $unit)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return mixed
     */
    public function restore(User $user, Unit $unit)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the unit.
     *
     * @param  \App\Models\Users\User  $user
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return mixed
     */
    public function forceDelete(User $user, Unit $unit)
    {
        return $user->admin;
    }
}
