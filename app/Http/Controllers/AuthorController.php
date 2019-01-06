<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthorFormRequest;
use App\Author;
use Auth;

class AuthorController extends Controller
{
    public function createForm() {
        return view('authors.create');
    }

    public function create(AuthorFormRequest $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $author = Author::create($input);
        if ($author->id) {
            \Toast::success('Autor erfolgreich erstellt');
            return view('authors.create');
        } else {
            abort(500);
        }
    }
}
