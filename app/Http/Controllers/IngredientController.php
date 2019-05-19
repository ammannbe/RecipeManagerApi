<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\CreateIngredient;

class IngredientController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateIngredient  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIngredient $request)
    {
        Ingredient::create($request->all());
        \Toast::success(__('toast.ingredient.created'));

        return redirect()->route('admin.index');
    }
}
