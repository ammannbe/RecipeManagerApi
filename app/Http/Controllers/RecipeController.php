<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeFormRequest;
use App\Helpers\RecipeHelper;
use App\Author;
use App\Category;
use App\Cookbook;
use App\IngredientDetail;
use App\Recipe;
use Auth;
use File;

class RecipeController extends Controller
{
    public function show(Recipe $recipe) {
        Recipe::setDetails($recipe);
        foreach ($recipe->ingredientDetails as $key => &$ingredientDetail) {
            $ingredientDetail->display = RecipeHelper::beautifyIngredientDetail($ingredientDetail);

            if ($ingredientDetail->ingredient_detail_id) {
                $ingredientDetail->alternate = IngredientDetail::find($ingredientDetail->ingredient_detail_id);
                $ingredientDetail->alternate->display = RecipeHelper::beautifyIngredientDetail($ingredientDetail->alternate);
            }

            if ($ingredientDetail->group) {
                $ingredientDetailGroups[$ingredientDetail->group->name][] = $ingredientDetail;
            }
        }
        return view('recipes.index', compact('recipe', 'ingredientDetailGroups'));
    }

    public function createForm() {
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        foreach (Author::orderBy('name')->get() as $author) {
            $authors[$author->id] = $author->name;
        }

        foreach (Category::orderBy('name')->get() as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('recipes.create', compact('authors', 'cookbooks', 'categories'));
    }

    public function create(RecipeFormRequest $request) {
        $input = $request->all();
        if (isset($input['photo'])) {
            $input['photo'] = time().'.'.request()->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images/recipes'), $input['photo']);
        }
        $input['user_id'] = Auth::user()->id;
        $recipe = Recipe::create($input);
        if ($recipe->id) {
            $recipe->categories()->attach($input['categories']);
            \Toast::success('Rezept erfolgreich erstellt');
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function editForm(Recipe $recipe) {
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        foreach (Author::orderBy('name')->get() as $author) {
            $authors[$author->id] = $author->name;
        }

        foreach (Category::orderBy('name')->get() as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('recipes.edit', compact('recipe', 'authors', 'cookbooks', 'categories'));
    }

    public function edit(RecipeFormRequest $request, Recipe $recipe) {
        $input = $request->all();

        if (!isset($input['delete_photo']) && !isset($input['photo'])) {
            unset($input['photo']);
        } elseif (isset($input['delete_photo']) && !isset($input['photo'])) {
            $input['photo'] = NULL;
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
        } else {
            $input['photo'] = time().'.'.request()->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images/recipes'), $input['photo']);
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
        }

        if ($recipe->update($input)) {
            (isset($input['categories']) ? $categories = $input['categories'] : $categories = NULL);
            $recipe->categories()->sync($categories);
            \Toast::success('Rezept erfolgreich aktualisiert.');
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function delete(Recipe $recipe) {
        if (Auth::user()->id == $recipe->user_id) {
            if ($recipe->delete()) {
                File::delete(public_path().'/images/recipes/'.$recipe->photo);

                \Toast::success('Rezept erfolgreich gelöscht.');
                return redirect('/');
            } else {
                abort(500);
            }
        } else {
            \Toast::error('Du hast kein Recht dieses Rezept zu löschen.');
            return redirect('/recipes/'.$recipe->id);
        }
    }
}