<?php

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Cookbook;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\Cookbook\Index;
use App\Http\Requests\Recipes\Cookbook\Store;
use App\Http\Requests\Recipes\Cookbook\Update;

class CookbookController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Cookbook::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Index  $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Index $request)
    {
        $model = new Cookbook();
        if ($request->trashed && auth()->check()) {
            $model = $model->withTrashed();
        }

        return $model->paginate($request->limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $cookbook = auth()->user()->cookbooks()->create($request->validated());
        return $this->responseCreated('cookbooks.show', $cookbook->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return \App\Models\Recipes\Cookbook
     */
    public function show(Cookbook $cookbook)
    {
        return $cookbook;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Update  $request
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return void
     */
    public function update(Update $request, Cookbook $cookbook)
    {
        $cookbook->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return void
     */
    public function destroy(Cookbook $cookbook)
    {
        $cookbook->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $cookbook = Cookbook::onlyTrashed()->findOrFail($id);
        $this->authorize($cookbook);
        $cookbook->restore();
    }
}
