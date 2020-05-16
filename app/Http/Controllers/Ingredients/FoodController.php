<?php

namespace App\Http\Controllers\Ingredients;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\Food;
use App\Http\Requests\Ingredients\Food\Store;
use App\Http\Requests\Ingredients\Food\Update;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(Food::class);
        return Food::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Food\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Food::class);
        $food = Food::create($request->validated());
        return $this->responseCreated('foods.show', $food->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        $this->authorize($food);
        return $food;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Food\Update  $request
     * @param  \App\Models\Ingredients\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, Food $food)
    {
        $this->authorize($food);
        $food->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $this->authorize($food);
        $food->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $food = Food::onlyTrashed()->findOrFail($id);
        $this->authorize($food);
        $food->restore();
    }
}
