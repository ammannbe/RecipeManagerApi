<?php

namespace App\Observers\Ingredients;

use App\Models\Ingredients\Ingredient;

class IngredientObserver
{
    /**
     * Handle the ingredient "saving" event.
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return void
     */
    public function saving(Ingredient $ingredient): void
    {
        if ($ingredient->isDirty('ingredient_id')) {
            $ingredient->adoptIngredientGroupFromParent();
        }

        if ($ingredient->amount_max === 0) {
            $ingredient->amount_max = null;
        }

        if ($ingredient->amount === 0 && !$ingredient->amount_max) {
            $ingredient->amount = null;
        }
    }
}
