<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller
{
    public function index() {
        return Recipe::all();
    }

    public function show(Recipe $recipe) {
        return $recipe;
    }

    public function store(Request $request) {
        $recipe = Recipe::create($request->all());
        return response()->json($recipe, 201);
    }

    public function update(Request $request, Recipe $recipe) {
        $recipe->update($request->all());
        return response()->json($recipe, 200);
    }

    public function delete(Recipe $recipe) {
        $recipe->delete();
        return response()->json(null, 204);
    }
}
