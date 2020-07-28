<?php

namespace App\Http\Controllers\Ingredients;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientAttribute;
use App\Http\Requests\Ingredients\IngredientAttribute\Store;
use App\Http\Requests\Ingredients\IngredientAttribute\Update;

class IngredientAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $this->authorize(IngredientAttribute::class);
        return IngredientAttribute::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientAttribute\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(IngredientAttribute::class);
        $ingredientAttribute = IngredientAttribute::create($request->validated());
        return $this->responseCreated('ingredient-attributes.show', $ingredientAttribute->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return \App\Models\Ingredients\IngredientAttribute
     */
    public function show(IngredientAttribute $ingredientAttribute)
    {
        $this->authorize($ingredientAttribute);
        return $ingredientAttribute;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientAttribute\Update  $request
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return void
     */
    public function update(Update $request, IngredientAttribute $ingredientAttribute)
    {
        $this->authorize($ingredientAttribute);
        $ingredientAttribute->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\IngredientAttribute  $ingredientAttribute
     * @return void
     */
    public function destroy(IngredientAttribute $ingredientAttribute)
    {
        $this->authorize($ingredientAttribute);
        $ingredientAttribute->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        /** @var \App\Models\Ingredients\IngredientAttribute $ingredientAttribute */
        $ingredientAttribute = IngredientAttribute::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredientAttribute);
        $ingredientAttribute->restore();
    }
}
