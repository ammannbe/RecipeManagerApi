<?php

namespace App\Http\Controllers\Ingredients;

use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientDetailGroup;
use App\Http\Requests\Ingredients\IngredientDetailGroup\Store;
use App\Http\Requests\Ingredients\IngredientDetailGroup\Update;

class IngredientDetailGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Recipe $recipe)
    {
        $this->authorize([IngredientDetailGroup::class, $recipe]);
        return $recipe->ingredientDetailGroups()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientDetailGroup\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Recipe $recipe, Store $request)
    {
        $this->authorize([IngredientDetailGroup::class, $recipe]);
        $ingredientDetailGroup = $recipe->ingredientDetailGroups()->create($request->validated());
        return $this->responseCreated('ingredient-detail-groups.show', $ingredientDetailGroup->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientDetailGroup $ingredientDetailGroup)
    {
        $this->authorize($ingredientDetailGroup);
        return $ingredientDetailGroup;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientDetailGroup\Update  $request
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, IngredientDetailGroup $ingredientDetailGroup)
    {
        $this->authorize($ingredientDetailGroup);
        $ingredientDetailGroup->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\IngredientDetailGroup  $ingredientDetailGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngredientDetailGroup $ingredientDetailGroup)
    {
        $this->authorize($ingredientDetailGroup);
        $ingredientDetailGroup->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $ingredientDetailGroup = IngredientDetailGroup::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredientDetailGroup);
        $ingredientDetailGroup->restore();
    }
}
