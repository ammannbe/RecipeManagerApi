<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Prep;
use App\Unit;
use App\Recipe;
use App\Ingredient;
use App\IngredientDetail;
use App\IngredientDetailGroup;
use App\Helpers\CodeHelper;
use App\Helpers\RecipeHelper;
use App\Helpers\FormHelper;
use App\Http\Requests\CreateIngredientDetail;

class IngredientDetailController extends Controller
{
    public function createForm(Recipe $recipe) {
        $this->authorize('create', [IngredientDetail::class, $recipe]);

        $units = [NULL => 'Bitte wählen'] + Unit::orderBy('name')->pluck('name', 'id')->toArray();
        $preps = Prep::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredients = [NULL => 'Bitte wählen'] + Ingredient::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredientDetailGroups = [NULL => 'Bitte wählen'] + IngredientDetailGroup::orderBy('name')
            ->where('recipe_id', $recipe->id)
            ->pluck('name', 'id')
            ->toArray();

        $default['ingredientDetailGroup'] = array_search(request()->input('group'), $ingredientDetailGroups);

        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->with('unit', 'ingredient', 'preps')
            ->get();

        $ingredientDetailsAlternate = [NULL => 'Bitte wählen'];
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

    public function create(CreateIngredientDetail $request, Recipe $recipe) {
        $ingredientDetail = new IngredientDetail($request->all());
        $ingredientDetail->recipe_id = $recipe->id;
        $ingredientDetail->save();

        if ($request->preps) {
            $ingredientDetail->preps()->sync($request->preps);
        } else {
            $ingredientDetail->preps()->detach();
        }

        \Toast::success('Zutat erfolgreich hinzugefügt');
        return redirect("ingredient-details/create/{$recipe->slug}");
    }

    public function delete(IngredientDetail $ingredientDetail) {
        $this->authorize('delete', [IngredientDetail::class, $ingredientDetail->recipe]);
        $ingredientDetail->delete();
        if (! IngredientDetail::where(['ingredient_detail_group_id' => $ingredientDetail->ingredient_detail_group_id])->exists()) {
            IngredientDetailGroup::find($ingredientDetail->ingredient_detail_group_id)->delete();
        }
        \Toast::success('Zutat erfolgreich gelöscht.');

        return redirect("recipes/{$ingredientDetail->recipe->slug}");
    }
}
