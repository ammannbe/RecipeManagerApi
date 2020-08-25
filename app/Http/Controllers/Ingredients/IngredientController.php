<?php

namespace App\Http\Controllers\Ingredients;

use Illuminate\Http\Request;
use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Models\Ingredients\Ingredient;
use App\Http\Requests\Ingredients\Ingredient\Store;
use App\Http\Requests\Ingredients\Ingredient\Update;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request, Recipe $recipe)
    {
        $this->authorize([Ingredient::class, $recipe]);
        $ingredients = $recipe
            ->ingredients()
            ->orderBy('ingredient_group_id')
            ->orderBy('position')
            ->originalOnly()
            ->get();

        if ($request->grouped) {
            return $ingredients->groupBy('ingredient_group_id');
        }

        return $ingredients;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Ingredient\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Recipe $recipe)
    {
        $this->authorize([Ingredient::class, $recipe]);
        $validated = $request->validated();

        $position = $validated['position'] ?? null;
        unset($validated['position']);

        $ingredient = $recipe->ingredients()->create($validated);

        $ingredient->updatePosition($position);

        if (isset($validated['ingredient_attributes'])) {
            $ingredient->ingredientAttributes()->sync($validated['ingredient_attributes']);
        }

        return $this->responseCreated('ingredients.show', $ingredient->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return \App\Models\Ingredients\Ingredient
     */
    public function show(Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        return $ingredient;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Ingredient\Update  $request
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return void
     */
    public function update(Update $request, Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        $validated = $request->validated();

        $position = $validated['position'] ?? null;
        unset($validated['position']);

        if (isset($validated['ingredient_attributes'])) {
            $ingredient->ingredientAttributes()->sync($validated['ingredient_attributes']);
        }

        $ingredient->update($validated);

        $ingredient->updatePosition($position);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return void
     */
    public function destroy(Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        $ingredient->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $ingredient = Ingredient::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredient);
        $ingredient->restore();
    }
}
