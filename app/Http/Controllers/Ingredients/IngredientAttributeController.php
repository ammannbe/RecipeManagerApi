<?php

namespace App\Http\Controllers\Ingredients;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientAttribute;
use App\Http\Requests\Ingredients\IngredientAttribute\Index;
use App\Http\Requests\Ingredients\IngredientAttribute\Store;
use App\Http\Requests\Ingredients\IngredientAttribute\Update;

class IngredientAttributeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(IngredientAttribute::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Ingredients\IngredientAttribute\Index  $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Index $request)
    {
        if ($request->trashed && auth()->user()->admin) {
            return IngredientAttribute::withTrashed()->get();
        }
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
        $ingredientAttribute = IngredientAttribute::onlyTrashed()->findOrFail($id);
        $this->authorize($ingredientAttribute);
        $ingredientAttribute->restore();
    }
}
