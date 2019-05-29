<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\RatingCriterion;
use Illuminate\Http\Request;
use App\Http\Requests\EditRating;
use App\Http\Requests\CreateRating;

class RatingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Recipe $recipe)
    {
        $this->authorize('create', [Rating::class, $recipe]);
        $ratingCriteria = [NULL => __('forms.global.dropdown_first')] + RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();
        return view('ratings.create', compact('recipe', 'ratingCriteria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateRating  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRating $request, Recipe $recipe)
    {
        $rating = new Rating($request->all());
        $rating->user_id = auth()->user()->id;
        $rating->recipe_id = $recipe->id;
        $rating->save();
        \Toast::success(__('toast.rating.created'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe, Rating $rating)
    {
        $this->authorize('update', [Rating::class, $rating]);
        $ratingCriteria = RatingCriterion::orderBy('name')->pluck('name', 'id')->toArray();
        $recipe = Recipe::find($rating->recipe_id);

        return view('ratings.edit', compact('rating', 'ratingCriteria', 'recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditRating  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(EditRating $request, Recipe $recipe, Rating $rating)
    {
        $rating->update([
            'comment'             => $request->comment,
            'stars'               => $request->stars,
            'rating_criterion_id' => $request->rating_criterion_id,
        ]);
        \Toast::success(__('toast.rating.updated'));
        $recipe = Recipe::find($rating->recipe_id);

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, Rating $rating)
    {
        $this->authorize('update', [Rating::class, $rating]);
        $rating->delete();
        \Toast::success(__('toast.rating.deleted'));
        $recipe = Recipe::find($rating->recipe_id);

        return redirect()->route('recipes.show', $recipe->slug);
    }
}
