<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory as CreateCategoryFormRequest;
use App\Helpers\FormHelper;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    public function createForm() {
        return view('categories.create');
    }

    public function create(CreateCategoryFormRequest $request) {
        if (Category::create($request->all())) {
            \Toast::success('Kategorie erfolgreich erstellt');
            return view('categories.create');
        } else {
            abort(500);
        }
    }
}
