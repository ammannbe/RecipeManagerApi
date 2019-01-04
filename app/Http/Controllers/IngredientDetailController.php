<?php

namespace App\Http\Controllers;

use \App\Unit;
use \App\Ingredient;
use \App\IngredientDetail;
use \App\Prep;
use \App\Recipe;
use Request;
use Auth;

class IngredientDetailController extends Controller
{
    public function createForm(Recipe $recipe) {
        $units[NULL] = '-- SELECT--';
        foreach (Unit::get() as $unit) {
            $units[$unit->id] = $unit->name;
        }

        $ingredients[NULL] = '-- SELECT--';
        foreach (Ingredient::get() as $ingredient) {
            $ingredients[$ingredient->id] = $ingredient->name;
        }

        $preps[NULL] = '-- NONE--';
        foreach (Prep::get() as $prep) {
            $preps[$prep->id] = $prep->name;
        }

        return view('recipes.ingredients', compact('recipe', 'units', 'ingredients', 'preps'));
    }

    public function create(Recipe $recipe) {
        $input = Request::all();
        $input['recipe_id'] = $recipe->id;
        $ingredientDetail = IngredientDetail::create($input);
        if ($ingredientDetail->id) {
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
