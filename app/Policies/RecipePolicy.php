<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }

    public function delete(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }
}
