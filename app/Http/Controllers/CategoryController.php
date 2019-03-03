<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use App\Helpers\FormHelper;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    public function createForm() {
        return view('categories.create');
    }

    public function create(CategoryFormRequest $request) {
        $input = $request->all();
        $category = Category::create($input);
        if ($category->id) {
            \Toast::success('Kategorie erfolgreich erstellt');
            return view('categories.create');
        } else {
            abort(500);
        }
    }
}
