<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Prep;
use App\Unit;
use App\Recipe;
use App\Ingredient;
use App\IngredientDetail;
use App\Helpers\CodeHelper;
use App\Helpers\RecipeHelper;
use App\IngredientDetailGroup;
use App\Http\Requests\IngredientDetailFormRequest;

class IngredientDetailController extends Controller
{
    public function createForm(Recipe $recipe) {
        $units = [];
        foreach (Unit::orderBy('name')->get() as $unit) {
            $units[$unit->id] = $unit->name;
        }

        $ingredients = [];
        foreach (Ingredient::orderBy('name')->get() as $ingredient) {
            $ingredients[$ingredient->id] = $ingredient->name;
        }

        $preps = [];
        foreach (Prep::orderBy('name')->get() as $prep) {
            $preps[$prep->id] = $prep->name;
        }

        $ingredientDetailGroups = [];
        foreach (IngredientDetailGroup::orderBy('name')->where('recipe_id', $recipe->id)->get() as $ingredientDetailGroup) {
            $ingredientDetailGroups[$ingredientDetailGroup->id] = $ingredientDetailGroup->name;
        }

        $ingredientDetailsAlternate = [];
        foreach (IngredientDetail::get() as $ingredientDetailAlternate) {
            $ingredientDetailsAlternate[$ingredientDetailAlternate->id] = RecipeHelper::beautifyIngredientDetail($ingredientDetailAlternate);;
        }

        return view('ingredientDetails.create', compact('recipe', 'units', 'ingredients', 'preps', 'ingredientDetailGroups', 'ingredientDetailsAlternate'));
    }

    public function create(IngredientDetailFormRequest $request, Recipe $recipe) {
        $input = $request->all();
        $ingredientDetail = new IngredientDetail;

        if ($input['unit']) {
            if (! $unit = Unit::where('name', $input['unit'])->first()) {
                $unit = Unit::create(['name' => $input['unit'], 'user_id' => $user->id]);
            }
            $ingredientDetail->unit_id = $unit->id;
        }

        if ($input['ingredient']) {
            if (! $ingredient = Ingredient::where('name', $input['ingredient'])->first()) {
                $ingredient = Ingredient::create(['name' => $input['ingredient']]);
            }
            $ingredientDetail->ingredient_id = $ingredient->id;
        }

        if ($input['prep']) {
            if (! $prep = Prep::where('name', $input['prep'])->first()) {
                $prep = Prep::create(['name' => $input['prep']]);
            }
            $ingredientDetail->prep_id = $prep->id;
        }

        if ($input['ingredient_detail_group']) {
            if (! $ingredient_detail_group = IngredientDetailGroup::where('name', $input['ingredient_detail_group'])->first()) {
                $ingredient_detail_group = IngredientDetailGroup::create(['recipe_id' => $recipe->id, 'name' => $input['ingredient_detail_group']]);
            }
            $ingredientDetail->ingredient_detail_group_id = $ingredient_detail_group->id;
        }

        $ingredientDetail->ingredient_detail_id = CodeHelper::weakArrayTypeCheck($input, 'ingredient_detail_id');

        $ingredientDetail->recipe_id    = $recipe->id;
        $ingredientDetail->amount       = $input['amount'];
        $ingredientDetail->amount_max   = $input['amount_max'];
        $ingredientDetail->position     = $input['position'];

        if ($ingredientDetail->save()) {
            \Toast::success('Zutat erfolgreich hinzugefügt');
            return redirect('recipes/'.$recipe->id);
        }
    }

    public function delete(IngredientDetail $ingredientDetail) {
        $recipe = Recipe::find($ingredientDetail->recipe_id);
        if (Auth::user()->id == $recipe->user_id) {
            if ($ingredientDetail->delete()) {
                \Toast::success('Zutat erfolgreich gelöscht.');
                return redirect('/recipes/'.$recipe->id);
            } else {
                abort(500);
            }
        } else {
            \Toast::error('Du hast kein Recht diese Zutat zu löschen.');
            return redirect('/recipes/'.$recipe->id);
        }
    }
}
