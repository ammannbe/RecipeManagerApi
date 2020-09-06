<?php

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\Tag\Index;
use App\Http\Requests\Recipes\Tag\Store;
use App\Http\Requests\Recipes\Tag\Update;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Recipes\Tag\Index  $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Index $request)
    {
        $this->authorize(Tag::class);
        if ($request->trashed) {
            return Tag::withTrashed()->get();
        }
        return Tag::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Tag\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Tag::class);
        $tag = Tag::create($request->validated());
        return $this->responseCreated('tags.show', $tag->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Tag  $tag
     * @return \App\Models\Recipes\Tag
     */
    public function show(Tag $tag)
    {
        $this->authorize($tag);
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Tag\Update  $request
     * @param  \App\Models\Recipes\Tag  $tag
     * @return void
     */
    public function update(Update $request, Tag $tag)
    {
        $this->authorize($tag);
        $tag->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Tag  $tag
     * @return void
     */
    public function destroy(Tag $tag)
    {
        $this->authorize($tag);
        $tag->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $this->authorize($tag);
        $tag->restore();
    }
}
