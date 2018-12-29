<?php

namespace App\Http\Controllers\Api\v1;
use App\Ingredient;

use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index() {
        return IngredientController::all();
    }

    public function show(IngredientController $ingredientController) {
        return $ingredientController;
    }

    public function store(Request $request) {
        $ingredientController = IngredientController::create($request->all());
        return response()->json($ingredientController, 201);
    }

    public function update(Request $request, IngredientController $ingredientController) {
        $ingredientController->update($request->all());
        return response()->json($ingredientController, 200);
    }

    public function delete(IngredientController $ingredientController) {
        $ingredientController->delete();
        return response()->json(null, 204);
    }
}
