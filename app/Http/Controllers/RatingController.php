<?php

namespace App\Http\Controllers;

use \App\RatingCriterion;
use \App\Recipe;
use \App\Rating;
use \Request;
use App\Http\Requests\RatingFormRequest;
use \Auth;

class RatingController extends Controller
{
    public function createForm(Recipe $recipe) {
        foreach (RatingCriterion::orderBy('name')->get() as $ratingCriterion) {
            $ratingCriteria[$ratingCriterion->id] = $ratingCriterion->name;
        }

        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(RatingFormRequest $request, Recipe $recipe) {
        $input = $request->all();
        $input['recipe_id'] = $recipe->id;
        $input['user_id'] = Auth::user()->id;
        $rating = Rating::create($input);
        if ($rating->id) {
            return redirect('recipes/'.$recipe->id);
        }
    }

    public function editForm(Rating $rating) {
        foreach (RatingCriterion::orderBy('name')->get() as $ratingCriterion) {
            $ratingCriteria[$ratingCriterion->id] = $ratingCriterion->name;
        }
        return view('ratings.edit', compact('rating', 'ratingCriteria'));
    }

    public function edit(RatingFormRequest $request, Rating $rating) {
        $input = $request->all();

        if ($rating->update($input)) {
            \Toast::success('Rezept erfolgreich aktualisiert.');
            return redirect('recipes/'.$rating->recipe_id);
        } else {
            abort(500);
        }
    }

    public function delete(Rating $rating) {
        if (Auth::user()->id == $rating->user_id) {
            if ($rating->delete()) {
                \Toast::success('Bewertung erfolgreich gelöscht.');
                return redirect('/recipes/'.$rating->recipe_id);
            } else {
                abort(500);
            }
        } else {
            \Toast::error('Du hast kein Recht diese Bewertung zu löschen.');
            return redirect('/recipes/'.$rating->recipe_id);
        }
    }
}
