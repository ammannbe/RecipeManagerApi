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

        $units = Unit::orderBy('name')->pluck('name', 'id')->toArray();
        $preps = Prep::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredients = Ingredient::orderBy('name')->pluck('name', 'id')->toArray();
        $ingredientDetailGroups = IngredientDetailGroup::orderBy('name')
            ->where('recipe_id', $recipe->id)
            ->pluck('name', 'id')
            ->toArray();

        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->with('unit', 'ingredient', 'preps')
            ->get();

        $ingredientDetailsAlternate = [];
        foreach ($ingredientDetails as $i) {
            $ingredientDetailsAlternate[$i->id] = RecipeHelper::beautifyIngredientDetail($i);
        }

        $compact = compact(
                'recipe',
                'units',
                'preps',
                'ingredients',
                'ingredientDetailGroups',
                'ingredientDetailsAlternate'
            );

        return view('ingredientDetails.create', $compact);
    }

    public function create(CreateIngredientDetail $request, Recipe $recipe) {
        $ingredientDetail = new IngredientDetail();

        if ($request->unit) {
            $ingredientDetail->unit_id = Unit::where('name', $request->unit)->first()->id;
        }
        if ($request->ingredient) {
            $ingredientDetail->ingredient_id = Ingredient::where('name', $request->ingredient)->first()->id;
        }
        if ($request->ingredient_detail_id) {
            $ingredientDetail->ingredient_detail_id = $request->ingredient_detail_id;
        }

        $ingredientDetail->recipe_id = $recipe->id;
        $ingredientDetail->amount    = $request->amount;
        $ingredientDetail->position  = $request->position;

        if ($request->ingredient_detail_group) {
            $ingredientDetailGroup = IngredientDetailGroup::firstOrCreate(
                [
                    'recipe_id' => $recipe->id,
                    'name'      => $request->ingredient_detail_group
                ]);
            $ingredientDetail->ingredient_detail_group_id = $ingredientDetailGroup->id;
        }

        $ingredientDetail->save();
        if ($request->preps) {
            $ingredientDetail->preps()->sync($request->preps);
        } else {
            $ingredientDetail->preps()->detach();
        }

        \Toast::success('Zutat erfolgreich hinzugefügt<br><a href="/recipes/'.$recipe->id.'">Zurück zum Rezept</a>');
        return redirect('ingredient-details/create/'.$recipe->id);
    }

    public function delete(IngredientDetail $ingredientDetail) {
        $this->authorize('delete', [IngredientDetail::class, $ingredientDetail->recipe]);
        $ingredientDetail->delete();
        if (! IngredientDetail::where(['ingredient_detail_group_id' => $ingredientDetail->ingredient_detail_group_id])->exists()) {
            IngredientDetailGroup::find($ingredientDetail->ingredient_detail_group_id)->delete();
        }
        \Toast::success('Zutat erfolgreich gelöscht.');

        return redirect('/recipes/'.$ingredientDetail->recipe->id);
    }
}
