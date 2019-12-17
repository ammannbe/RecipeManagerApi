<?php

namespace App\Http\Controllers\Ingredients;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\Ingredient;
use App\Http\Requests\Ingredients\Ingredient\Store;
use App\Http\Requests\Ingredients\Ingredient\Update;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(Ingredient::class);
        return Ingredient::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Ingredient\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Ingredient::class);
        $ingredient = Ingredient::create($request->validated());
        return $this->responseCreated('ingredients.show', $ingredient->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        return $ingredient;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Ingredient\Update  $request
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        $ingredient->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        $this->authorize($ingredient);
        $ingredient->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $ingredient = Ingredient::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredient);
        $ingredient->restore();
    }
}
