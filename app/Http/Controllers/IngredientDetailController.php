<?php

namespace App\Http\Controllers;

use App\Models\Prep;
use App\Models\Unit;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Helpers\RecipeHelper;
use App\Models\IngredientDetail;
use App\Models\IngredientDetailGroup;
use App\Http\Requests\EditIngredientDetail;
use App\Http\Requests\CreateIngredientDetail;

class IngredientDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function create(Recipe $recipe)
    {
        $this->authorize('create', [IngredientDetail::class, $recipe]);

        $units = [null => __('forms.global.dropdown_first')] + Unit::orderBy('name')->pluck('name', 'id')->toArray();
        $preps = Prep::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredients = [null => __('forms.global.dropdown_first')] + Ingredient::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredientDetailGroups = [null => __('forms.global.dropdown_first')] + IngredientDetailGroup::orderBy('name')
            ->where('recipe_id', $recipe->id)
            ->pluck('name', 'id')
            ->toArray();

        $default['ingredientDetailGroup'] = array_search(request()->input('group'), $ingredientDetailGroups);

        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->with('unit', 'ingredient', 'preps')
            ->get();

        $ingredientDetailsAlternate = [null => __('forms.global.dropdown_first')];
        foreach ($ingredientDetails as $i) {
            $ingredientDetailsAlternate[$i->id] = RecipeHelper::beautifyIngredientDetail($i);
        }

        $compact = compact(
            'recipe',
            'units',
            'preps',
            'ingredients',
            'ingredientDetailGroups',
            'ingredientDetailsAlternate',
            'default'
        );

        return view('ingredientDetails.create', $compact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateIngredientDetail  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIngredientDetail $request, Recipe $recipe)
    {
        $ingredientDetail = new IngredientDetail($request->all());
        $ingredientDetail->recipe_id = $recipe->id;
        $ingredientDetail->save();

        if ($request->preps) {
            $ingredientDetail->preps()->sync($request->preps);
        } else {
            $ingredientDetail->preps()->detach();
        }

        IngredientDetail::reorder($recipe);

        \Toast::success(__('toast.ingredient.created'));
        return redirect()->route('recipes.ingredient-details.create', $recipe->slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @param  \App\Models\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe, IngredientDetail $ingredientDetail)
    {
        $this->authorize('update', [IngredientDetail::class, $recipe]);

        $units = [null => __('forms.global.dropdown_first')] + Unit::orderBy('name')->pluck('name', 'id')->toArray();
        $preps = Prep::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredients = [null => __('forms.global.dropdown_first')] + Ingredient::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredientDetailGroups = [null => __('forms.global.dropdown_first')] + IngredientDetailGroup::orderBy('name')
            ->where('recipe_id', $recipe->id)
            ->pluck('name', 'id')
            ->toArray();

        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->with('unit', 'ingredient', 'preps')
            ->get();

        $ingredientDetailsAlternate = [null => __('forms.global.dropdown_first')];
        foreach ($ingredientDetails as $i) {
            $ingredientDetailsAlternate[$i->id] = RecipeHelper::beautifyIngredientDetail($i);
        }
        unset($ingredientDetailsAlternate[$ingredientDetail->id]);

        $compact = compact(
            'recipe',
            'units',
            'preps',
            'ingredients',
            'ingredientDetail',
            'ingredientDetailGroups',
            'ingredientDetailsAlternate'
        );

        return view('ingredientDetails.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditIngredientDetail  $request
     * @param  \App\Models\Recipe  $recipe
     * @param  \App\Models\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function update(EditIngredientDetail $request, Recipe $recipe, IngredientDetail $ingredientDetail)
    {
        $ingredientDetail->fill($request->all());
        $ingredientDetail->update();

        if ($request->preps) {
            $ingredientDetail->preps()->sync($request->preps);
        } else {
            $ingredientDetail->preps()->detach();
        }

        IngredientDetail::reorder($recipe);

        \Toast::success(__('toast.recipe.updated'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, IngredientDetail $ingredientDetail)
    {
        $this->authorize('delete', [IngredientDetail::class, $recipe]);
        $group_id = $ingredientDetail->ingredient_detail_group_id;
        $ingredientDetail->delete();
        if (!IngredientDetail::where(['ingredient_detail_group_id' => $group_id])->exists()) {
            IngredientDetailGroup::find($group_id)->delete();
        }
        \Toast::success(__('toast.ingredient.deleted'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param \App\Models\Recipe $recipe
     * @param  int $id IngredientDetail-ID
     * @return \Illuminate\Http\Response
     */
    public function restore(Recipe $recipe, int $id)
    {
        $ingredientDetail = IngredientDetail::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', [IngredientDetail::class, $recipe]);
        $ingredientDetail->restore();

        \Toast::success(__('toast.recipe.restored'));
        return back();
    }
}
