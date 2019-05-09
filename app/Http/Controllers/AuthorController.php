<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthor;
use App\Helpers\FormHelper;
use App\Author;
use Auth;

class AuthorController extends Controller
{
    public function createForm() {
        return view('authors.create');
    }

    public function create(CreateAuthor $request) {
        $request->merge(['user_id' => auth()->user()->id]);
        Author::create($request->all());
        \Toast::success(__('toast.author.created'));

        return redirect('/admin');
    }
}
