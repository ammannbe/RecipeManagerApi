<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\FormatHelper;
use App\Http\Requests\CreateCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateCategory  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        $request->merge(['slug' => FormatHelper::slugify($request->name)]);
        Category::create($request->all());
        \Toast::success(__('toast.category.created'));

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $recipes = Recipe::where('category_id', $category->id)->get();
        return view('categories.show', compact('category', 'recipes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        if (! Recipe::where('category_id', $category->id)->first()) {
            $category->delete();
            \Toast::success(__('toast.category.deleted'));
        } else {
            \Toast::error(__('toast.category.not_deleted'));
        }

        return back();
    }
}
