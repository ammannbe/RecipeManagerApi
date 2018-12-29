<?php

namespace App\Http\Controllers;

use \App\Cookbook;
use \App\Author;
use \App\Category;
use \App\Recipe;
use Request;

class RecipeController extends Controller
{
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

    public function create() {
        $input = Request::all();
        $recipe = Recipe::create($input);
        if ($recipe->id) {
            return redirect('recipes/'.$recipe->id);
        }
    }
}
