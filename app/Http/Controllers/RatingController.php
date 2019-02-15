<?php

namespace App\Http\Controllers;

use \App\RatingCriterion;
use \App\Recipe;
use \App\Rating;
use App\Helpers\FormHelper;
use \Request;
use App\Http\Requests\RatingFormRequest;
use \Auth;

class RatingController extends Controller
{
    public function createForm(Recipe $recipe) {
        $ratingCriteria = [];
        foreach (RatingCriterion::orderBy('name')->get() as $ratingCriterion) {
            $ratingCriteria[$ratingCriterion->id] = $ratingCriterion->name;
        }

        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(RatingFormRequest $request, Recipe $recipe) {
        $rating = new Rating;
        $rating->recipe_id = $recipe->id;
        $rating->user_id    = Auth::user()->id;
        $rating->comment    = $request->input('comment');

        if ($request->input('rating_criterion')) {
            if (! $ratingCriterion = RatingCriterion::where('name', $request->input('rating_criterion'))->first()) {
                \Toast::error('Dieses Kriterium existiert nicht!');
                return redirect('/ratings/add/'.$recipe->id)->withInput();
            }
            $rating->rating_criterion_id = $ratingCriterion->id;
        }

        if ($rating->save()) {
            return redirect('recipes/'.$recipe->id);
        }
    }

    public function editForm(Rating $rating) {
        foreach (RatingCriterion::orderBy('name')->get() as $ratingCriterion) {
            $ratingCriteria[$ratingCriterion->id] = $ratingCriterion->name;
            if ($rating->rating_criterion_id == $ratingCriterion->id) {
                $default['ratingCriterion'] = $ratingCriterion;
            }
        }
        return view('ratings.edit', compact('rating', 'ratingCriteria', 'default'));
    }

    public function edit(RatingFormRequest $request, Rating $rating) {
        $rating->user_id    = Auth::user()->id;
        $rating->comment    = $request->input('comment');

        if ($request->input('rating_criterion')) {
            if (! $ratingCriterion = RatingCriterion::where('name', $request->input('rating_criterion'))->first()) {
                return redirect('/ratings/edit/'.$recipe->id)
                    ->withErrors(['Dieses Kriterium existiert nicht!'])
                    ->withInput();
            }
            $rating->rating_criterion_id = $ratingCriterion->id;
        }

        if ($rating->update()) {
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
