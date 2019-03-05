<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthor as CreateAuthorFormRequest;
use App\Helpers\FormHelper;
use App\Author;
use Auth;

class AuthorController extends Controller
{
    public function createForm() {
        return view('authors.create');
    }

    public function create(CreateAuthorFormRequest $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        if (Author::create($input)) {
            \Toast::success('Autor erfolgreich erstellt');
            return view('authors.create');
        } else {
            abort(500);
        }
    }
}
