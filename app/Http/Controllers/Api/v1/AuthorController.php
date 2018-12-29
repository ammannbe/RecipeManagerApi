<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Author;

class AuthorController extends Controller
{
    public function index() {
        return Author::all();
    }

    public function show(Author $author) {
        return $author;
    }

    public function store(Request $request) {
        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update(Request $request, Author $author) {
        $author->update($request->all());
        return response()->json($author, 200);
    }

    public function delete(Author $author) {
        $author->delete();
        return response()->json(null, 204);
    }
}
