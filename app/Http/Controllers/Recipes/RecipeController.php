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
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        $this->authorize(Recipe::class);

        $model = new Recipe();
        if ($request->trashed == 'true' && auth()->check()) {
            $model = $model->withTrashed();
        }
        if (TagController::isEnabled()) {
            $model->with('tags');
        }
        $paginator = $model
            ->filter($request->filter, $request->method)
            ->paginate($request->limit);
        $paginator->setCollection($paginator->getCollection()->makeVisible('deleted_at'));
        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipe\Store  $request
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
     * @return \Illuminate\Http\Response
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
     * @param  \App\Http\Requests\Recipe\Update  $request
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $recipe = Recipe::onlyTrashed()->findOrFail($id);
        $this->authorize($recipe);
        $recipe->restore();
    }

    /**
     * Show the recipe image
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function image(Recipe $recipe, string $name)
    {
        $this->authorize('view', $recipe);

        if (!\Storage::disk('recipe_images')->exists("{$recipe->id}/{$name}")) {
            abort(404);
        }

        return \Storage::disk('recipe_images')->download("{$recipe->id}/{$name}");
    }
}
