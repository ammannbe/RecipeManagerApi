<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\IngredientDetail;
use App\Models\IngredientDetailGroup;
use App\Http\Requests\EditIngredientDetailGroup;
use App\Http\Requests\CreateIngredientDetailGroup;

class IngredientDetailGroupController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Recipe $recipe)
    {
        return view('ingredientDetailGroups.create', compact('recipe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateIngredientDetailGroup  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIngredientDetailGroup $request, Recipe $recipe)
    {
        $ingredientDetailGroup = new IngredientDetailGroup($request->all());
        $ingredientDetailGroup->recipe_id = $recipe->id;
        $ingredientDetailGroup->save();

        \Toast::success(__('toast.ingredient-detail-group.created'));
        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IngredientDetailGroup  $ingredientDetailGroup
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe, IngredientDetailGroup $ingredientDetailGroup)
    {
        $this->authorize('update', [IngredientDetailGroup::class, $recipe]);

        return view('ingredientDetailGroups.edit', compact('ingredientDetailGroup', 'recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EditIngredientDetailGroup  $request
     * @param  \App\Models\IngredientDetailGroup  $ingredientDetailGroup
     * @return \Illuminate\Http\Response
     */
    public function update(EditIngredientDetailGroup $request, Recipe $recipe, IngredientDetailGroup $ingredientDetailGroup)
    {
        $ingredientDetailGroup->name = $request->name;
        $ingredientDetailGroup->update();

        \Toast::success(__('toast.ingredient-detail-group.updated'));

        return redirect()->route('recipes.show', $ingredientDetailGroup->recipe->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @param  \App\Models\IngredientDetailGroup  $ingredientDetailGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, IngredientDetailGroup $ingredientDetailGroup)
    {
        $this->authorize('delete', [IngredientDetailGroup::class, $recipe]);
        $ingredientDetailGroup->delete();
        \Toast::success(__('toast.ingredient-detail-group.deleted'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param \App\Models\Recipe $recipe
     * @param  Int $id IngredientDetailGroup-ID
     * @return \Illuminate\Http\Response
     */
    public function restore(Recipe $recipe, Int $id)
    {
        $ingredientDetailGroup = IngredientDetailGroup::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', [IngredientDetailGroup::class, $recipe]);
        $ingredientDetailGroup->restore();

        \Toast::success(__('toast.recipe.restored'));
        return back();
    }
}
