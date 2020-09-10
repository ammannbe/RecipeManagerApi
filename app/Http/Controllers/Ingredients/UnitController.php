<?php

namespace App\Http\Controllers\Ingredients;

use App\Models\Ingredients\Unit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ingredients\Unit\Index;
use App\Http\Requests\Ingredients\Unit\Store;
use App\Http\Requests\Ingredients\Unit\Update;

class UnitController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Unit::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Ingredients\Unit\Index  $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Index $request)
    {
        if ($request->trashed && auth()->user()->admin) {
            return Unit::withTrashed()->get();
        }
        return Unit::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Unit\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $unit = Unit::create($request->validated());
        return $this->responseCreated('units.show', $unit->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return \App\Models\Ingredients\Unit
     */
    public function show(Unit $unit)
    {
        return $unit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ingredients\Unit\Update  $request
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return void
     */
    public function update(Update $request, Unit $unit)
    {
        $unit->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return void
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $unit = Unit::onlyTrashed()->findOrFail($id);
        $this->authorize($unit);
        $unit->restore();
    }
}
