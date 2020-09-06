<?php

namespace App\Http\Controllers\Ratings;

use App\Http\Controllers\Controller;
use App\Models\Ratings\RatingCriterion;
use App\Http\Requests\Ratings\RatingCriterion\Store;
use App\Http\Requests\Ratings\RatingCriterion\Update;

class RatingCriterionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RatingCriterion::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
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
        $ratingCriterion->delete();
    }
}
