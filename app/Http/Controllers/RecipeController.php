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
use App\Http\Requests\EditRecipe as EditRecipeFormRequest;
use App\Http\Requests\CreateRecipe as CreateRecipeFormRequest;

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
        $cookbooks  = CodeHelper::getCollectionProperty(Cookbook::orderBy('name')->get());
        $authors    = CodeHelper::getCollectionProperty(Author::orderBy('name')->get());
        $categories = CodeHelper::getCollectionProperty(Category::orderBy('name')->get());

        return view('recipes.create', compact('authors', 'cookbooks', 'categories'));
    }

    public function create(CreateRecipeFormRequest $request) {
        $recipe = new Recipe();

        if ($request->photo) {
            $recipe->photo = time() . '-' .
                FormatHelper::slugify($request->name) . '.' .
                request()->photo->getClientOriginalExtension();

            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        $recipe->cookbook_id = CodeHelper::getObjectProperty('Cookbook', $request->cookbook);
        if (! $recipe->cookbook_id) {
            return redirect('/recipes/create')
                ->withErrors(['Dieses Kochbuch existiert nicht!'])
                ->withInput();
        }

        $recipe->author_id = CodeHelper::getObjectProperty('Author', $request->author);
        if (! $recipe->author_id) {
            return redirect('/recipes/create')
                ->withErrors(['Dieser Autor existiert nicht!'])
                ->withInput();
        }

        $recipe->category_id = CodeHelper::getObjectProperty('Category', $request->category);
        if (! $recipe->category_id) {
            return redirect('/recipes/create')
                ->withErrors(['Diese Kategorie existiert nicht!'])
                ->withInput();
        }

        $recipe->user_id          = Auth::user()->id;
        $recipe->name             = $request->name;
        $recipe->yield_amount     = $request->yield_amount;
        $recipe->instructions     = $request->instructions;
        $recipe->preparation_time = $request->preparation_time;

        if ($recipe->save()) {
            \Toast::success('Rezept erfolgreich erstellt');
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function editForm(Recipe $recipe) {
        $cookbooks  = CodeHelper::getCollectionProperty(Cookbook::orderBy('name')->get());
        $authors    = CodeHelper::getCollectionProperty(Author::orderBy('name')->get());
        $categories = CodeHelper::getCollectionProperty(Category::orderBy('name')->get());

        return view('recipes.edit', compact('recipe', 'authors', 'cookbooks', 'categories'));
    }

    public function edit(EditRecipeFormRequest $request, Recipe $recipe) {
        if ($request->yield_amount) {
            $recipe->yield_amount = $request->yield_amount;
        }

        if ($request->preparation_tme) {
            $recipe->preparation_tme = $request->preparation_tme;
        }

        $recipe->instructions = $request->instructions;
        if (! $recipe->instructions) {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Die Zubereitung fehlt!'])
                ->withInput();
        }

        $recipe->cookbook_id = CodeHelper::getObjectProperty('Cookbook', $request->cookbook);
        if (! $recipe->cookbook_id) {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Dieses Kochbuch existiert nicht!'])
                ->withInput();
        }

        $recipe->author_id = CodeHelper::getObjectProperty('Author', $request->author);
        if (! $recipe->cookbook_id && $request->author) {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Dieser Author existiert nicht!'])
                ->withInput();
        }

        $recipe->category_id = CodeHelper::getObjectProperty('Category', $request->category);
        if (! $recipe->cookbook_id) {
            return redirect('/recipes/edit/'.$recipe->id)
                ->withErrors(['Dieses Kategorie existiert nicht!'])
                ->withInput();
        }

        if ($request->delete_photo && !$request->photo) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);
            $recipe->photo = NULL;
        } elseif($request->photo) {
            File::delete(public_path().'/images/recipes/'.$recipe->photo);

            $nameSlug = FormatHelper::slugify($request->name);
            $recipe->photo = $nameSlug.'-'.time().'.'.request()->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images/recipes'), $recipe->photo);
        }

        if ($recipe->update()) {
            \Toast::success('Rezept erfolgreich aktualisiert.');
            return redirect('recipes/'.$recipe->id);
        } else {
            abort(500);
        }
    }

    public function delete(Recipe $recipe) {
        if (Auth::user()->id === $recipe->user_id) {
            if ($recipe->delete()) {
                File::delete(public_path().'/images/recipes/'.$recipe->photo);

                \Toast::success('Rezept erfolgreich gelöscht.');
                return redirect('/');
            } else {
                abort(500);
            }
        } else {
            abort(403);
        }
    }
}
