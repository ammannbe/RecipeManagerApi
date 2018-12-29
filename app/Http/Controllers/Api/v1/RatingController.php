<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Rating;

class RatingController extends Controller
{
    public function index() {
        return Rating::all();
    }

    public function show(Rating $rating) {
        return $rating;
    }

    public function store(Request $request) {
        $rating = Rating::create($request->all());
        return response()->json($rating, 201);
    }

    public function update(Request $request, Rating $rating) {
        $rating->update($request->all());
        return response()->json($rating, 200);
    }

    public function delete(Rating $rating) {
        $rating->delete();
        return response()->json(null, 204);
    }
}
