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
use App\Http\Requests\CreateIngredientDetail as CreateIngredientDetailFormRequest;

class IngredientDetailController extends Controller
{
    public function createForm(Recipe $recipe) {
        $units                  = CodeHelper::getCollectionProperty(Unit::orderBy('name')->get());
        $preps                  = CodeHelper::getCollectionProperty(Prep::orderBy('name')->get());
        $ingredients            = CodeHelper::getCollectionProperty(Ingredient::orderBy('name')->get());
        $ingredientDetailGroups = CodeHelper::getCollectionProperty(
                IngredientDetailGroup::orderBy('name')->where('recipe_id', $recipe->id)->get()
            );

        $ingredientDetailsAlternate = [];
        foreach (IngredientDetail::get() as $i) {
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

    public function create(CreateIngredientDetailFormRequest $request, Recipe $recipe) {
        $ingredientDetail = new IngredientDetail();

        if ($request->unit) {
            $unit = Unit::where('name', $request->unit)->first();
            if (! $unit) {
                \Toast::error('Diese Einheit existiert nicht!');
                return redirect('/ingredient-details/create/'.$recipe->id)->withInput();
            }
            $ingredientDetail->unit_id = $unit->id;
        }

        if ($request->ingredient) {
            $ingredient = Ingredient::where('name', $request->ingredient)->first();
            if (! $ingredient) {
                \Toast::error('Diese Zutat existiert nicht!');
                return redirect('/ingredient-details/create/'.$recipe->id)->withInput();
            }
            $ingredientDetail->ingredient_id = $ingredient->id;
        }

        if ($request->prep) {
            $prep = Prep::where('name', $request->prep)->first();
            if (! $prep) {
                \Toast::error('Diese Vorbereitung existiert nicht!');
                return redirect('/ingredient-details/create/'.$recipe->id)->withInput();
            }
            $ingredientDetail->prep_id = $prep->id;
        }

        if ($request->ingredient_detail_group) {
            $ingredientDetailGroup = IngredientDetailGroup::where(
                    'name', $request->ingredient_detail_group
                )->first();

            if (! $ingredientDetailGroup) {
                $ingredientDetailGroup = IngredientDetailGroup::create([
                        'recipe_id' => $recipe->id,
                        'name'      => $request->ingredient_detail_group,
                    ]);
            }
            $ingredientDetail->ingredient_detail_group_id = $ingredientDetailGroup->id;
        }

        $ingredientDetail->ingredient_detail_id = CodeHelper::weakArrayTypeCheck(
                $request->all(), 'ingredient_detail_id'
            );

        $ingredientDetail->recipe_id = $recipe->id;
        $ingredientDetail->amount    = $request->amount;
        $ingredientDetail->position  = $request->position;

        if ($ingredientDetail->save()) {
            \Toast::success('Zutat erfolgreich hinzugefügt');
            return redirect('recipes/'.$recipe->id);
        }
    }

    public function delete(IngredientDetail $ingredientDetail) {
        $recipe = Recipe::find($ingredientDetail->recipe_id);
        if (Auth::user()->id === $recipe->user_id) {
            if ($ingredientDetail->delete()) {
                \Toast::success('Zutat erfolgreich gelöscht.');
                return redirect('/recipes/'.$recipe->id);
            } else {
                abort(500);
            }
        } else {
            return redirect('/recipes/'.$recipe->id)
                ->withErrors(['Du hast kein Recht diese Zutat zu löschen.']);
        }
    }
}
