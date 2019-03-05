<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Rating;
use App\Recipe;
use App\RatingCriterion;
use App\Helpers\CodeHelper;
use App\Helpers\FormHelper;
use App\Http\Requests\EditRating as EditRatingFormRequest;
use App\Http\Requests\CreateRating as CreateRatingFormRequest;

class RatingController extends Controller
{
    public function createForm(Recipe $recipe) {
        $ratingCriteria = CodeHelper::getCollectionProperty(RatingCriterion::orderBy('name')->get());
        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(CreateRatingFormRequest $request, Recipe $recipe) {
        $rating             = new Rating();
        $rating->recipe_id  = $recipe->id;
        $rating->user_id    = Auth::user()->id;
        $rating->comment    = $request->comment;

        if ($request->rating_criterion) {
            $ratingCriterion = RatingCriterion::where('name', $request->rating_criterion)->first();
            if (! $ratingCriterion) {
                \Toast::error('Dieses Kriterium existiert nicht!');
                return redirect('/ratings/add/'.$recipe->id)->withInput();
            }
            $rating->rating_criterion_id = $ratingCriterion->id;
        }

        if ($rating->save()) {
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function editForm(Rating $rating) {
        $ratingCriteria = CodeHelper::getCollectionProperty(RatingCriterion::orderBy('name')->get());
        $default['ratingCriterion'] = RatingCriterion::find($rating->rating_criterion_id);

        return view('ratings.edit', compact('rating', 'ratingCriteria', 'default'));
    }

    public function edit(EditRatingFormRequest $request, Rating $rating) {
        if (Auth::user()->id === $rating->user_id) {
            $rating->comment = $request->comment;

            if ($request->rating_criterion) {
                $ratingCriterion = RatingCriterion::where('name', $request->rating_criterion)->first();
                if (! $ratingCriterion) {
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
        } else {
            abort(403);
        }
    }

    public function delete(Rating $rating) {
        if (Auth::user()->id === $rating->user_id) {
            if ($rating->delete()) {
                \Toast::success('Bewertung erfolgreich gelöscht.');
                return redirect('/recipes/'.$rating->recipe_id);
            } else {
                abort(500);
            }
        } else {
            abort(403);
        }
    }
}
