<?php

namespace App\Http\Controllers;

use App\Prep;
use App\Unit;
use App\Recipe;
use App\Ingredient;
use App\IngredientDetail;
use Illuminate\Http\Request;
use App\Helpers\RecipeHelper;
use App\IngredientDetailGroup;
use App\Http\Requests\CreateIngredientDetail;

class IngredientDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Recipe $recipe)
    {
        $this->authorize('create', [IngredientDetail::class, $recipe]);

        $units = [NULL => __('forms.global.dropdown_first')] + Unit::orderBy('name')->pluck('name', 'id')->toArray();
        $preps = Prep::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredients = [NULL => __('forms.global.dropdown_first')] + Ingredient::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredientDetailGroups = [NULL => __('forms.global.dropdown_first')] + IngredientDetailGroup::orderBy('name')
            ->where('recipe_id', $recipe->id)
            ->pluck('name', 'id')
            ->toArray();

        $default['ingredientDetailGroup'] = array_search(request()->input('group'), $ingredientDetailGroups);

        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->with('unit', 'ingredient', 'preps')
            ->get();

        $ingredientDetailsAlternate = [NULL => __('forms.global.dropdown_first')];
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

        \Toast::success(__('toast.ingredient.created'));
        return redirect()->route('recipes.ingredient-details.create', $recipe->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IngredientDetail  $ingredientDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, IngredientDetail $ingredientDetail)
    {
        $this->authorize('delete', [IngredientDetail::class, $recipe]);
        $ingredientDetail->delete();
        if (! IngredientDetail::where(['ingredient_detail_group_id' => $ingredientDetail->ingredient_detail_group_id])->exists()) {
            IngredientDetailGroup::find($ingredientDetail->ingredient_detail_group_id)->delete();
        }
        \Toast::success(__('toast.ingredient.deleted'));

        return redirect()->route('recipes.index', $ingreidentDetail->recipe->slug);
    }
}
