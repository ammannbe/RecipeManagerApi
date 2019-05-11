<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAuthor;

class AuthorController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateAuthor  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAuthor $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        Author::create($request->all());
        \Toast::success(__('toast.author.created'));

        return redirect()->route('admin.index');
    }
}
