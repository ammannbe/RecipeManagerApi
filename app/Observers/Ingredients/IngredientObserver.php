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
    public function saving(Ingredient $ingredient)
    {
        if ($ingredient->isDirty('position')) {
            $this->reorder($ingredient);
        }
    }

    /**
     * Reorder the ingridients position
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return void
     */
    private function reorder(Ingredient $ingredient)
    {
        $withSamePosition = Ingredient::where([
            'recipe_id'             => $ingredient->recipe_id,
            'ingredient_group_id'   => $ingredient->ingredient_group_id,
            'ingredient_id'         => $ingredient->ingredient_id,
            'position'              => $ingredient->position,
        ])->withTrashed();

        if (!$withSamePosition->exists()) {
            return true;
        }

        if ($ingredient->getOriginal('position') < $ingredient->position) {
            $withSamePosition->withTrashed()->decrement('position', 1);
        } else {
            $withSamePosition->withTrashed()->increment('position', 1);
        }
    }
}
