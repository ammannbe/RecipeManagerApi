<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAuthor;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('name')->get();
        return view('authors.index', compact('authors'));
    }

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
        $request->merge([
                'user_id' => auth()->user()->id,
                'slug' => FormatHelper::slugify($request->name)
            ]);
        Author::create($request->all());
        \Toast::success(__('toast.author.created'));

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $recipes = Recipe::where('author_id', $author->id)->get();
        return view('authors.show', compact('author', 'recipes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Author $author)
    {
        $this->authorize('delete', [Author::class, $author]);
        if (! Recipe::where('author_id', $author->id)->first()) {
            $author->delete();
            \Toast::success(__('toast.author.deleted'));
        } else {
            \Toast::error(__('toast.author.not_deleted'));
        }

        return back();
    }
}
