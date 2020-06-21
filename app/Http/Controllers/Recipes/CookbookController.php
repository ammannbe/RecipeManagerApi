<?php

namespace App\Http\Controllers\Recipes;

use Illuminate\Http\Request;
use App\Models\Recipes\Cookbook;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\Cookbook\Index;
use App\Http\Requests\Recipes\Cookbook\Store;
use App\Http\Requests\Recipes\Cookbook\Update;

class CookbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        $this->authorize(Cookbook::class);
        $model = new Cookbook();
        if ($request->trashed == 'true' && auth()->check()) {
            $model = $model->withTrashed();
        }

        $paginator = $model->paginate($request->limit);
        $paginator->setCollection($paginator->getCollection()->makeVisible('deleted_at'));
        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Cookbook::class);
        $cookbook = auth()->user()->cookbooks()->create($request->validated());
        return $this->responseCreated('cookbooks.show', $cookbook->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return \Illuminate\Http\Response
     */
    public function show(Cookbook $cookbook)
    {
        $this->authorize($cookbook);
        return $cookbook;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Cookbook\Update  $request
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, Cookbook $cookbook)
    {
        $this->authorize($cookbook);
        $cookbook->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cookbook $cookbook)
    {
        $this->authorize($cookbook);
        $cookbook->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $cookbook = Cookbook::onlyTrashed()->findOrFail($id);
        $this->authorize($cookbook);
        $cookbook->restore();
    }
}
