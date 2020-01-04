<?php

namespace App\Http\Controllers\Ingredients;

use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientDetail;
use App\Http\Requests\Ingredients\IngredientDetail\Store;
use App\Http\Requests\Ingredients\IngredientDetail\Update;

class IngredientDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function index(Recipe $recipe)
    {
        $this->authorize([IngredientDetail::class, $recipe]);;
        return $recipe->ingredientDetails()->exceptAlternates()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Recipe $recipe)
    {
        $this->authorize([IngredientDetail::class, $recipe]);
        $validated = $request->validated();
        $ingredientDetail = $recipe->ingredientDetails()->create($validated);
        if (isset($validated['ingredient_attributes'])) {
            $ingredientDetail->ingredientAttributes()->sync($validated['ingredient_attributes']);
        }
        return $this->responseCreated('ingredient-details.show', $ingredientDetail->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientDetail $ingredientDetail)
    {
        $this->authorize($ingredientDetail);
        return $ingredientDetail;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, IngredientDetail $ingredientDetail)
    {
        $this->authorize($ingredientDetail);
        $validated = $request->validated();
        if (isset($validated['ingredient_attributes'])) {
            $ingredientDetail->ingredientAttributes()->sync($validated['ingredient_attributes']);
        }
        $ingredientDetail->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngredientDetail $ingredientDetail)
    {
        $this->authorize($ingredientDetail);
        $ingredientDetail->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $ingredientDetail = IngredientDetail::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredientDetail);
        $ingredientDetail->restore();
    }
}
