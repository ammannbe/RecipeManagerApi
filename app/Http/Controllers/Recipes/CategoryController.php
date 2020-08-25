<?php

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\Category\Store;
use App\Http\Requests\Recipes\Category\Update;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $this->authorize(Category::class);
        return Category::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Category\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Category::class);
        $category = Category::create($request->validated());
        return $this->responseCreated('categories.show', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Category  $category
     * @return \App\Models\Recipes\Category
     */
    public function show(Category $category)
    {
        $this->authorize($category);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Category\Update  $request
     * @param  \App\Models\Recipes\Category  $category
     * @return void
     */
    public function update(Update $request, Category $category)
    {
        $this->authorize($category);
        $category->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Category  $category
     * @return void
     */
    public function destroy(Category $category)
    {
        $this->authorize($category);
        $category->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $this->authorize($category);
        $category->restore();
    }
}
