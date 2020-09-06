<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\Author;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Author\Store;
use App\Http\Requests\Users\Author\Update;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $this->authorize(Author::class);
        return Author::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\Author\Store  $request
     * @return void
     */
    public function store(Store $request)
    {
        $this->authorize(Author::class);
        Author::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users\Author  $author
     * @return \App\Models\Users\Author
     */
    public function show(Author $author)
    {
        $this->authorize($author);
        return $author;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\Author\Update  $request
     * @param  \App\Models\Users\Author  $author
     * @return void
     */
    public function update(Update $request, Author $author)
    {
        $this->authorize($author);
        $author->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users\Author  $author
     * @return void
     */
    public function destroy(Author $author)
    {
        $this->authorize($author);
        $author->delete();
    }
}
