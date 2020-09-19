<?php

namespace App\Http\Controllers\Ingredients;

use App\Models\Ingredients\Food;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ingredients\Food\Index;
use App\Http\Requests\Ingredients\Food\Store;
use App\Http\Requests\Ingredients\Food\Update;

class FoodController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Food::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Ingredients\Food\Index  $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Index $request)
    {
        if ($request->trashed && auth()->user()->admin) {
            return Food::withTrashed()->get();
        }
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
        $food = Food::create($request->validated());
        return $this->responseCreated('foods.show', $food->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\Food  $food
     * @return \App\Models\Ingredients\Food
     */
    public function show(Food $food)
    {
        return $food;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Food\Update  $request
     * @param  \App\Models\Ingredients\Food  $food
     * @return void
     */
    public function update(Update $request, Food $food)
    {
        $food->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\Food  $food
     * @return void
     */
    public function destroy(Food $food)
    {
        $food->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $food = Food::onlyTrashed()->findOrFail($id);
        $this->authorize($food);
        $food->restore();
    }
}
