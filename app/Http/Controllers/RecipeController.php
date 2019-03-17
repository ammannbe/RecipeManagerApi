<?php

namespace App\Http\Controllers;

use Auth;
use File;
use App\Author;
use App\Recipe;
use App\Category;
use App\Cookbook;
use App\IngredientDetail;
use App\Helpers\CodeHelper;
use App\Helpers\FormHelper;
use App\Helpers\FormatHelper;
use App\Helpers\RecipeHelper;
use App\Http\Requests\EditRecipe;
use App\Http\Requests\CreateRecipe;

class RecipeController extends Controller
{
    public function show(Recipe $recipe) {
        $gropus = $alternatives = [];
        $recipe->ingredientDetails->load('group', 'ingredientDetail');
        foreach ($recipe->ingredientDetails as $ingredientDetail) {
            if ($ingredientDetail->group && !$ingredientDetail->ingredient_detail_id) {
                $groups[$ingredientDetail->group->name][] = $ingredientDetail;
            } elseif ($ingredientDetail->ingredientDetail) {
                $alternatives[] = $ingredientDetail->ingredientDetail;
            }
        }
        return view('recipes.index', compact('recipe', 'groups', 'alternatives'));
    }

    public function createForm() {
        $cookbooks  = Cookbook::orderBy('name')->pluck('name', 'id')->toArray();
        $authors    =   Author::orderBy('name')->pluck('name', 'id')->toArray();
        $categories = Category::orderBy('name')->pluck('name', 'id')->toArray();

        return view('recipes.create', compact('authors', 'cookbooks', 'categories'));
    }

    public function create(CreateRecipe $request) {
        $recipe = array_merge(
                $request->all(),
                [
                    'cookbook_id' => Cookbook::where('name', $request->cookbook)->first()->id,
                    'author_id'   => Author::where('name', $request->author)->first()->id,
                    'category_id' => Category::where('name', $request->category)->first()->id,
                    'user_id'     => auth()->user()->id,
                    'slug'        => FormatHelper::slugify($request->name),
                ]
            );

        if ($request->photo) {
            $recipe['photo'] = FormatHelper::generatePhotoName(
                    $request->name,
                    $request->photo->getClientOriginalExtension()
                );
            $request->photo->move(public_path('images/recipes'), $recipe['photo']);
        }

        $recipe = Recipe::create($recipe);
        session(['edit-mode' => TRUE]);
        \Toast::success('Rezept erfolgreich erstellt');

        return redirect("recipes/{$recipe->slug}");
    }

    public function editForm(Recipe $recipe) {
        $this->authorize('update', [Recipe::class, $recipe]);

        $cookbooks  = Cookbook::orderBy('name')->pluck('name', 'id')->toArray();
        $authors    =   Author::orderBy('name')->pluck('name', 'id')->toArray();
        $categories = Category::orderBy('name')->pluck('name', 'id')->toArray();

        return view('recipes.edit', compact('recipe', 'authors', 'cookbooks', 'categories'));
    }

    public function edit(EditRecipe $request, Recipe $recipe) {
        $recipe->fill(array_merge(
                $request->all(),
                [
                    'cookbook_id' => Cookbook::where('name', $request->cookbook)->first()->id,
                    'author_id'   =>   Author::where('name', $request->author)->first()->id,
                    'category_id' => Category::where('name', $request->category)->first()->id,
                    'slug'        => FormatHelper::slugify($request->name),
                ]
            ));

        if ($request->preparation_time === '00:00') {
            $recipe->preparation_time = NULL;
        }

        if ($request->delete_photo && !$request->photo) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
            $recipe->photo = NULL;
        } elseif($request->photo) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
            $recipe->photo = FormatHelper::generatePhotoName(
                    $request->name,
                    request()->photo->getClientOriginalExtension()
                );
            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        $recipe->update();
        \Toast::success('Rezept erfolgreich aktualisiert.');

        return redirect("recipes/{$recipe->slug}");
    }

    public function delete(Recipe $recipe) {
        $this->authorize('delete', [Recipe::class, $recipe]);
        File::delete(public_path().'/images/recipes/'.$recipe->photo);
        $recipe->delete();

        \Toast::success('Rezept erfolgreich gelöscht.');
        return redirect('/');
    }
}
