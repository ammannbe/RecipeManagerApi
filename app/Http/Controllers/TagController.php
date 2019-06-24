<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\FormatHelper;
use App\Http\Requests\CreateTag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTag $request)
    {
        $request->merge(['slug' => FormatHelper::slugify($request->name)]);
        Tag::create($request->all());
        \Toast::success(__('toast.tag.created'));

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $recipes = $tag->recipes;
        return view('tags.show', compact('tag', 'recipes')); // TODO: vereinheitlichen in recipes/index?
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (! $tag->recipes->count()) {
            $tag->delete();
            \Toast::success(__('toast.tag.deleted'));
        } else {
            \Toast::error(__('toast.tag.not_deleted'));
        }

        return back();
    }
}
