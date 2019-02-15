<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IngredientFormRequest;
use App\Helpers\FormHelper;
use App\Ingredient;

class IngredientController extends Controller
{
    public function createForm() {
        return view('ingredients.create');
    }

    public function create(IngredientFormRequest $request) {
        $input = $request->all();
        $ingredient = Ingredient::create($input);
        if ($ingredient->id) {
            \Toast::success('Zutat erfolgreich erstellt');
            return view('ingredients.create');
        } else {
            abort(500);
        }
    }
}
