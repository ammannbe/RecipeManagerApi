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
     * Display a listing of the resource.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Support\Collection
     */
    public function index(Recipe $recipe)
    {
        $this->authorize(Rating::class);
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
        $this->authorize(Rating::class);
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
        $this->authorize($rating);
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
        $this->authorize($rating);
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
        $this->authorize($rating);
        $rating->delete();
    }
}
