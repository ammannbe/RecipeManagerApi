<?php

namespace App\Http\Controllers\Ratings;

use App\Http\Controllers\Controller;
use App\Models\Ratings\RatingCriterion;
use App\Http\Requests\Ratings\RatingCriterion\Store;
use App\Http\Requests\Ratings\RatingCriterion\Update;

class RatingCriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $this->authorize(RatingCriterion::class);
        return RatingCriterion::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ratings\RatingCriterion\Store  $request
     * @return void
     */
    public function store(Store $request)
    {
        $this->authorize(RatingCriterion::class);
        RatingCriterion::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return \App\Models\Ratings\RatingCriterion
     */
    public function show(RatingCriterion $ratingCriterion)
    {
        $this->authorize($ratingCriterion);
        return $ratingCriterion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ratings\RatingCriterion\Update  $request
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return void
     */
    public function update(Update $request, RatingCriterion $ratingCriterion)
    {
        $this->authorize($ratingCriterion);
        $ratingCriterion->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ratings\RatingCriterion  $ratingCriterion
     * @return void
     */
    public function destroy(RatingCriterion $ratingCriterion)
    {
        $this->authorize($ratingCriterion);
        $ratingCriterion->delete();
    }
}
