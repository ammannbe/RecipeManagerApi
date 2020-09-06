<?php

namespace App\Http\Controllers\Ratings;

use App\Models\Ratings\Rating;
use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ratings\Rating\Store;
use App\Http\Requests\Ratings\Rating\Update;

class RatingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Rating::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Support\Collection
     */
    public function index(Recipe $recipe)
    {
        return $recipe->ratings;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ratings\Rating\Store  $request
     * @return void
     */
    public function store(Store $request)
    {
        Rating::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ratings\Rating  $rating
     * @return \App\Models\Ratings\Rating
     */
    public function show(Rating $rating)
    {
        return $rating;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ratings\Rating\Update  $request
     * @param  \App\Models\Ratings\Rating  $rating
     * @return void
     */
    public function update(Update $request, Rating $rating)
    {
        $rating->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ratings\Rating  $rating
     * @return void
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
    }
}
