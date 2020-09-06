<?php

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\Recipe\Index;
use App\Http\Requests\Recipes\Recipe\Store;
use App\Http\Requests\Recipes\Recipe\Update;
use App\Http\Controllers\Recipes\TagController;
use App\Http\Controllers\Recipes\CookbookController;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Recipes\Recipe\Index  $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Index $request)
    {
        $this->authorize(Recipe::class);

        $model = Recipe::latest();
        if ($request->trashed && auth()->check()) {
            $model = $model->withTrashed();
        }
        if ($request->only_own && auth()->check()) {
            $model = $model->withoutGlobalScope('isAdminOrOwnOrPublic')->isOwn();
        }
        if (TagController::isEnabled()) {
            $model->with('tags');
        }

        return $model
            ->filter($request->filter, $request->method)
            ->paginate($request->limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Recipe\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->authorize(Recipe::class);
        $validated = $request->validated();
        $recipe = auth()->user()->recipes()->create($validated);
        if (isset($validated['tags'])) {
            $recipe->tags()->sync($validated['tags']);
        }
        $recipe->savePhotos($validated['photos'] ?? null);
        return $this->responseCreated('recipes.show', $recipe->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \App\Models\Recipes\Recipe
     */
    public function show(Recipe $recipe)
    {
        $this->authorize($recipe);
        if (TagController::isEnabled()) {
            $recipe->load('tags');
        }
        if (CookbookController::isEnabled()) {
            $recipe->load('cookbook');
        }
        $recipe->load(['author', 'category']);
        return $recipe;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\Recipe\Update  $request
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return void
     */
    public function update(Update $request, Recipe $recipe)
    {
        $this->authorize($recipe);
        $validated = $request->validated();
        if (TagController::isEnabled() && isset($validated['tags'])) {
            $recipe->tags()->sync($validated['tags']);
        }
        $recipe->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return void
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize($recipe);
        $recipe->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $recipe = Recipe::onlyTrashed()->findOrFail($id);
        $this->authorize($recipe);
        $recipe->restore();
    }

    /**
     * Stream PDF
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function pdf(Recipe $recipe)
    {
        $this->authorize('view', $recipe);

        return \PDF::loadView('pdf.recipe', ['recipe' => $recipe])->stream("{$recipe->name}.pdf");
    }

    /**
     * Show the recipe image
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @param  string  $name
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function image(Recipe $recipe, string $name)
    {
        $this->authorize('view', $recipe);

        if (!\Storage::disk('recipe_images')->exists("{$recipe->id}/{$name}")) {
            abort(404);
        }

        return \Storage::disk('recipe_images')->download("{$recipe->id}/{$name}", null, ['Content-Disposition' => 'inline']);
    }
}
