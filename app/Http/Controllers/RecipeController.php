<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Author;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\FormatHelper;
use App\Http\Requests\EditRecipe;
use App\Http\Requests\CreateRecipe;
use Illuminate\Support\Facades\File;
use App\Models\IngredientDetailGroup;

class RecipeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors    = [null => __('forms.global.dropdown_first')] + Author::orderBy('name')->pluck('name', 'id')->toArray();
        $categories = [null => __('forms.global.dropdown_first')] + Category::orderBy('name')->pluck('name', 'id')->toArray();
        $tags       = [null => __('forms.global.dropdown_first')] + Tag::orderBy('name')->pluck('name', 'id')->toArray();
        $complexityTypes = Recipe::getComplexityTypes();
        $default = [
            'authors' => array_search(auth()->user()->name, $authors),
            'complexityTypes' => 'normal',
        ];

        return view('recipes.create', compact('authors', 'categories', 'tags', 'complexityTypes', 'default'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateRecipe  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRecipe $request)
    {
        // Check for similar recipes
        foreach (Recipe::get() as $recipe) {
            if (metaphone($recipe->name) === metaphone($request->name)) {
                \Toast::error(__('validation.similar.recipe', ['recipe' => $recipe->name]));
                return redirect()->back()->withInput();
            }
        }

        $request->merge([
            'user_id' => auth()->user()->id,
            'slug'    => FormatHelper::slugify($request->name),
        ]);
        $recipe = $request->all();

        if ($request->photo) {
            $recipe['photo'] = FormatHelper::generatePhotoName(
                $request->name,
                $request->photo->getClientOriginalExtension()
            );
            $request->photo->move(public_path('images/recipes'), $recipe['photo']);
        }

        $recipe = Recipe::create($recipe);
        $recipe->tags()->sync($request->tags);
        \Toast::success(__('toast.recipe.created'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $groups = $alternatives = [];
        $recipe->ingredientDetails->load('group', 'ingredientDetail');
        foreach ($recipe->ingredientDetails as $ingredientDetail) {
            if ($ingredientDetail->group && !$ingredientDetail->ingredient_detail_id) {
                $groups[$ingredientDetail->group->id]['model'] = $ingredientDetail->group;
                $groups[$ingredientDetail->group->id]['ingredients'][] = $ingredientDetail;
            } elseif ($ingredientDetail->ingredientDetails) {
                $alternatives[] = $ingredientDetail->ingredientDetails;
            }
        }
        foreach ($recipe->groups as $group) {
            if (!isset($groups[$group->id])) {
                $groups[$group->id]['model'] = $group;
                $groups[$group->id]['ingredients'] = null;
            }
        }
        return view('recipes.show', compact('recipe', 'groups', 'alternatives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', [Recipe::class, $recipe]);

        $authors    =   Author::orderBy('name')->pluck('name', 'id')->toArray();
        $categories = Category::orderBy('name')->pluck('name', 'id')->toArray();
        $tags       = [null => __('forms.global.dropdown_first')] + Tag::orderBy('name')->pluck('name', 'id')->toArray();
        $complexityTypes = Recipe::getComplexityTypes();

        return view('recipes.edit', compact('recipe', 'authors', 'categories', 'tags', 'complexityTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditRecipe  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(EditRecipe $request, Recipe $recipe)
    {
        $recipe->fill(array_merge(
            $request->all(),
            [
                'author_id'   => $request->author_id,
                'category_id' => $request->category_id,
                'slug'        => FormatHelper::slugify($request->name),
            ]
        ));

        $recipe->user_id = auth()->user()->id; // Overwrite user_id for securiy

        if ($request->preparation_time === '00:00') {
            $recipe->preparation_time = null;
        }

        $recipe->tags()->sync($request->tags);

        if ($request->delete_photo && !$request->photo) {
            File::delete(public_path() . '/images/recipes/' . $recipe->photo);
            $recipe->photo = null;
        } elseif ($request->photo) {
            File::delete(public_path() . '/images/recipes/' . $recipe->photo);
            $recipe->photo = FormatHelper::generatePhotoName(
                $request->name,
                request()->photo->getClientOriginalExtension()
            );
            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        $recipe->update();
        \Toast::success(__('toast.recipe.updated'));

        return redirect()->route('recipes.show', $recipe->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', [Recipe::class, $recipe]);
        $recipe->delete();

        \Toast::success(__('toast.recipe.deleted'));
        return redirect()->route('home');
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  int $id Recipe ID
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $recipe = Recipe::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', [Recipe::class, $recipe]);
        $recipe->restore();

        \Toast::success(__('toast.recipe.restored'));
        return back();
    }
}
