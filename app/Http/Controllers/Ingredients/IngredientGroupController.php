<?php

namespace App\Http\Controllers\Ingredients;

use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientGroup;
use App\Http\Requests\Ingredients\IngredientGroup\Store;
use App\Http\Requests\Ingredients\IngredientGroup\Update;

class IngredientGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index(Recipe $recipe)
    {
        $this->authorize([IngredientGroup::class, $recipe]);
        return $recipe->ingredientGroups()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientGroup\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Recipe $recipe, Store $request)
    {
        $this->authorize([IngredientGroup::class, $recipe]);
        $ingredientGroup = $recipe->ingredientGroups()->create($request->validated());
        return $this->responseCreated('ingredient-groups.show', $ingredientGroup->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return \App\Models\Ingredients\IngredientGroup
     */
    public function show(IngredientGroup $ingredientGroup)
    {
        $this->authorize($ingredientGroup);
        return $ingredientGroup;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientGroup\Update  $request
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return void
     */
    public function update(Update $request, IngredientGroup $ingredientGroup)
    {
        $this->authorize($ingredientGroup);
        $ingredientGroup->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return void
     */
    public function destroy(IngredientGroup $ingredientGroup)
    {
        $this->authorize($ingredientGroup);
        $ingredientGroup->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $ingredientGroup = IngredientGroup::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredientGroup);
        $ingredientGroup->restore();
    }
}
