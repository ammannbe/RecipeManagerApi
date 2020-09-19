<?php

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\RecipePhoto\Store;

class RecipePhotoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Recipes\RecipePhoto\Store  $request
     * @return void
     */
    public function store(Store $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        $validated = $request->validated();
        foreach ($validated['photos'] ?? [] as $photo) {
            $recipe->addPhoto($photo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @param  string  $photo
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(Recipe $recipe, string $photo)
    {
        $this->authorize('view', $recipe);

        if (!\Storage::disk('recipe_images')->exists("{$recipe->id}/{$photo}")) {
            abort(404);
        }

        return \Storage::disk('recipe_images')
            ->download("{$recipe->id}/{$photo}", null, ['Content-Disposition' => 'inline']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @param  string  $photo
     * @return void
     */
    public function destroy(Recipe $recipe, string $photo)
    {
        $this->authorize('update', $recipe);
        $recipe->removePhoto($photo);
    }
}
