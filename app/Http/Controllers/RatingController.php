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
        $ratingCriteria = [NULL => __('form.dropdown-first')] + RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();
        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    public function create(CreateRatingFormRequest $request, Recipe $recipe) {
        $rating = new Rating($request->all());
        $rating->user_id = auth()->user()->id;
        $rating->recipe_id = $recipe->id;
        $rating->save();
        \Toast::success(__('toast.rating.created'));

        return redirect("recipes/{$recipe->slug}");
    }

    public function editForm(Rating $rating) {
        $this->authorize('update', [Rating::class, $rating]);
        $ratingCriteria = RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();
        $recipe = Recipe::find($rating->recipe_id);

        return view('ratings.edit', compact('rating', 'ratingCriteria', 'recipe'));
    }

    public function edit(EditRatingFormRequest $request, Rating $rating) {
        $rating->update([
            'comment'             => $request->comment,
            'stars'               => $request->stars,
            'rating_criterion_id' => $request->rating_criterion_id,
        ]);
        \Toast::success(__('toast.rating.updated'));
        $recipe = Recipe::find($rating->recipe_id);

        return redirect("recipes/{$recipe->slug}");
    }

    public function delete(Rating $rating) {
        $this->authorize('update', [Rating::class, $rating]);
        $rating->delete();
        \Toast::success(__('toast.rating.deleted'));
        $recipe = Recipe::find($rating->recipe_id);

        return redirect("recipes/{$recipe->slug}");
    }
}
