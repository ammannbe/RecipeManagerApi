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
        $this->authorize('create', [Rating::class, $recipe]);
        $ratingCriteria = RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();
        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(CreateRatingFormRequest $request, Recipe $recipe) {
        $rating = [
            'recipe_id'           => $recipe->id,
            'user_id'             => auth()->user()->id,
            'comment'             => $request->comment,
            'rating_criterion_id' => RatingCriterion::where('name', $request->rating_criterion)->first()->id,
        ];
        Rating::create($rating);
        \Toast::success('Bewertung gespeichert.');

        return redirect("recipes/{$recipe->slug}");
    }

    public function editForm(Rating $rating) {
        $this->authorize('update', [Rating::class, $rating]);
        $ratingCriteria = RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();

        return view('ratings.edit', compact('rating', 'ratingCriteria'));
    }

    public function edit(EditRatingFormRequest $request, Rating $rating) {
        $rating->update([
            'comment'             => $request->comment,
            'rating_criterion_id' => RatingCriterion::where('name', $request->rating_criterion)->first()->id,
        ]);
        \Toast::success('Rezept erfolgreich aktualisiert.');

        return redirect('recipes/'.$rating->recipe_id);
    }

    public function delete(Rating $rating) {
        $this->authorize('update', [Rating::class, $rating]);
        $rating->delete();
        \Toast::success('Bewertung erfolgreich gelöscht.');
        return redirect('recipes/'.$rating->recipe_id);
    }
}
