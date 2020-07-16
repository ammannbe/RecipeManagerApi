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
            $this->adoptIngredientGroupFromParent($ingredient);
        }
    }

    /**
     * Adopt the ingredient group id from the parent, if present
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return void
     */
    private function adoptIngredientGroupFromParent(Ingredient $ingredient): void
    {
        if (!$ingredient->ingredient_id) {
            return;
        }

        $ingredient->ingredient_group_id = $ingredient->ingredient->ingredient_group_id;
    }
}
