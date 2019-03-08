<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIngredient as CreateIngredientFormRequest;
use App\Helpers\FormHelper;
use App\Ingredient;

class IngredientController extends Controller
{
    public function createForm() {
        return view('ingredients.create');
    }

    public function create(CreateIngredientFormRequest $request) {
        Ingredient::create($request->all());
        \Toast::success('Zutat erfolgreich erstellt');

        return view('ingredients.create');
    }
}
