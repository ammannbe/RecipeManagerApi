<?php

namespace App\Http\Controllers;

use Auth;
use File;
use App\Author;
use App\Recipe;
use App\Category;
use App\Cookbook;
use App\IngredientDetail;
use App\Helpers\FormHelper;
use App\Helpers\FormatHelper;
use App\Helpers\RecipeHelper;
use App\Http\Requests\RecipeFormRequest;

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
        $cookbooks = [];
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        $authors = [];
        foreach (Author::orderBy('name')->get() as $author) {
            $authors[$author->id] = $author->name;
        }

        $categories = [];
        foreach (Category::orderBy('name')->get() as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('recipes.create', compact('authors', 'cookbooks', 'categories'));
    }

    public function create(RecipeFormRequest $request) {
        $input = $request->all();
        $user = Auth::user();
        $recipe = new Recipe();

        if (isset($input['photo']) && $input['photo']) {
            $nameSlug = FormatHelper::slugify($input['name']);
            $recipe->photo = $nameSlug.'-'.time().'.'.request()->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        if (isset($input['cookbook']) && $input['cookbook']) {
            if (! $cookbook = Cookbook::where('name', $input['cookbook'])->first()) {
                return redirect('/recipes/create')
                    ->withErrors(['Dieses Kochbuch existiert nicht!'])
                    ->withInput();
            }
            $recipe->cookbook_id = $cookbook->id;
        }

        if (isset($input['author']) && $input['author']) {
            if (! $author = Author::where('name', $input['author'])->first()) {
                return redirect('/recipes/create')
                    ->withErrors(['Dieser Author existiert nicht!'])
                    ->withInput();
            }
            $recipe->author_id = $author->id;
        }

        $recipe->user_id            = $user->id;
        $recipe->name               = $input['name'];
        $recipe->yield_amount       = $input['yield_amount'];
        $recipe->yield_amount_max   = $input['yield_amount_max'];
        $recipe->instructions       = $input['instructions'];
        $recipe->preparation_time   = $input['preparation_time'];
        $recipe->save();

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

        if (! $cookbook = Cookbook::where('name', $input['cookbook'])->first()) {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Dieses Kochbuch existiert nicht!'])
                ->withInput();
        } else {
            $recipe->cookbook_id = $cookbook->id;
        }

        if (isset($input['author']) && $input['author']) {
            if (! $author = Author::where('name', $input['author'])->first()) {
                return redirect('/recipes/edit/'.$recipe->id)
                    ->withErrors(['Dieser Author existiert nicht!'])
                    ->withInput();
            } else {
                $recipe->author_id = $author->id;
            }
        } else {
            $recipe->author_id = NULL;
        }

        if (isset($input['yield_amount']) && $input['yield_amount']) {
            $recipe->yield_amount = $input['yield_amount'];
        }

        if (isset($input['yield_amount_max']) && $input['yield_amount_max']) {
            $recipe->yield_amount_max = $input['yield_amount_max'];
        }

        if (isset($input['instructions']) && $input['instructions']) {
            $recipe->instructions = $input['instructions'];
        } else {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Die Zubereitung fehlt!'])
                ->withInput();
        }

        if (isset($input['preparation_tme']) && $input['preparation_tme']) {
            $recipe->preparation_tme = $input['preparation_tme'];
        }

        if (isset($input['delete_photo']) && !isset($input['photo'])) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
            $recipe->photo = NULL;
        } elseif(isset($input['photo'])) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);

            $nameSlug = FormatHelper::slugify($input['name']);
            $recipe->photo = $nameSlug.'-'.time().'.'.request()->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        if ($recipe->update()) {
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
            return redirect('/recipes/'.$recipe->id)
                ->withErrors(['Du hast kein Recht dieses Rezept zu löschen.'])
                ->withInput();
        }
    }
}
