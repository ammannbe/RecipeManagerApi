<?php

namespace App\Http\Controllers\Recipes;

use Illuminate\Http\Request;
use App\Models\Recipes\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recipes\RecipePhoto\Store;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $recipe->addAllMediaFromRequest()->each(function (FileAdder $fileAdder) {
            $fileAdder->toMediaCollection('recipe_photos');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $photo
     * @param  string  $name
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(Request $request, Media $photo, string $name)
    {
        $this->authorize('view', $photo->model);

        foreach (['thumbnail', 'webp'] as $conversion) {
            if ($request->has($conversion) && $photo->hasGeneratedConversion($conversion)) {
                return response()->file($photo->getPath($conversion));
            }
        }

        return response()->file($photo->getPath());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $photo
     * @return void
     */
    public function destroy(Media $photo)
    {
        $this->authorize('update', $photo->model);
        $photo->delete();
    }
}
