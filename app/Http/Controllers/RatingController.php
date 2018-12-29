<?php

namespace App\Http\Controllers;

use \App\RatingCriterion;
use \App\Recipe;
use \App\Rating;
use \Request;
use \Auth;

class RatingController extends Controller
{
    public function createForm(Recipe $recipe) {
        $ratingCriteria[NULL] = '-- SELECT --';
        foreach (RatingCriterion::orderBy('name')->get() as $ratingCriterion) {
            $ratingCriteria[$ratingCriterion->id] = $ratingCriterion->name;
        }

        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(Recipe $recipe) {
        $input = Request::all();
        $input['recipe_id'] = $recipe->id;
        $input['user_id'] = Auth::user()->id;
        $rating = Rating::create($input);
        if ($rating->id) {
            return redirect('recipes/'.$recipe->id);
        }
    }
}
