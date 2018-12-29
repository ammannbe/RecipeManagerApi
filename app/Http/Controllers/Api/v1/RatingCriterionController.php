<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\RatingCriterion;

class RatingCriterionController extends Controller
{
    public function index() {
        return RatingCriterion::all();
    }

    public function show(RatingCriterion $ratingCriterion) {
        return $ratingCriterion;
    }

    public function store(Request $request) {
        $ratingCriterion = RatingCriterion::create($request->all());
        return response()->json($ratingCriterion, 201);
    }

    public function delete(RatingCriterion $ratingCriterion) {
        $ratingCriterion->delete();
        return response()->json(null, 204);
    }
}
