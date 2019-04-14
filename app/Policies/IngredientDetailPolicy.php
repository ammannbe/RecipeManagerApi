<?php

namespace App\Policies;

use App\User;
use App\Recipe;
use App\IngredientDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientDetailPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }

    public function delete(User $user, Recipe $recipe) {
        return ($user->id === $recipe->user_id) || ($user->isAdmin());
    }
}
