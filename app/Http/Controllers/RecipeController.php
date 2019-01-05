<?php

namespace App\Http\Controllers;

use App\Cookbook;
use App\Author;
use App\Category;
use App\Recipe;
use App\Http\Requests\RecipeFormRequest;
use Auth;

class RecipeController extends Controller
{

    public static function boot() {
        parent::boot();
        static::deleted(function($recipe) {
            $recipe->categories()->detach();
            $recipe->ingredientDetails()->delete();
            $recipe->ratings()->delete();
        });
    } 

    public function show(Recipe $recipe) {
        Recipe::setDetails($recipe);
        return view('recipes.index', compact('recipe'));
    }

    public function createForm() {
        $cookbooks[NULL] = '-- SELECT --';
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        $authors[NULL] = '-- SELECT --';
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
        $input['photo'] = file_get_contents($input['photo']);
        $input['user_id'] = Auth::user()->id;
        $recipe = Recipe::create($input);
        if ($recipe->id) {
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
        } else {
            $input['photo'] = file_get_contents($input['photo']);
        }

        if ($recipe->update($input)) {
            \Toast::success('Rezept erfolgreich aktualisiert.');
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function delete(Recipe $recipe) {
        if (Auth::user()->id == $recipe->user_id) {
            if ($recipe->delete()) {
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
