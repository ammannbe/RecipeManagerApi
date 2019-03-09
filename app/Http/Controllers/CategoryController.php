<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Helpers\FormHelper;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    public function createForm() {
        return view('categories.create');
    }

    public function create(CreateCategory $request) {
        Category::create($request->all());
        \Toast::success('Kategorie erfolgreich erstellt');

        return redirect('/admin');
    }
}
