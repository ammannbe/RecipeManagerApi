<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Recipe $recipe) {
        return ! Rating::where([
                'recipe_id' => $recipe->id,
                'user_id' => $user->id
            ])
            ->exists() || ($user->isAdmin());
    }

    public function update(User $user, Rating $rating) {
        return ($user->id === $rating->user_id) || ($user->isAdmin());
    }

    public function delete(User $user, Rating $rating) {
        return ($user->id === $rating->user_id) || ($user->isAdmin());
    }
}
