<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Author;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Helpers\FormHelper;
use App\Http\Requests\Search as SearchFormRequest;

class PagesController extends Controller
{
    public function index() {
        $ratings = Rating::with(['recipe', 'ratingCriterion'])
            ->latest()
            ->paginate(4);

        $recipes = Recipe::with('category', 'author', 'ratings')
            ->whereNotNull('photo');

        $topRecipes = Recipe::best($recipes->get(), 4, 4);
        $newRecipes = $recipes->latest()->paginate(4);

        return view('index', compact('newRecipes', 'ratings', 'topRecipes'));
    }

    public function searchForm($default = 'recipe') {
        $complete = [
            'author'   => Author::get()->pluck('name', 'id'),
            'category' => Category::get()->pluck('name', 'id'),
            'tag'      => Tag::get()->pluck('name', 'id'),
            'recipe'   => Recipe::get()->pluck('name', 'id'),
        ];

        $tables = [
            'author'     => __('forms.search.items.author'),
            'category'   => __('forms.search.items.category'),
            'tag'        => __('forms.search.items.tag'),
            'recipe'     => __('forms.search.items.recipe_preparation'),
            'ingredient' => __('forms.search.items.ingredient'),
        ];
        return view('search.index', compact('tables', 'default', 'complete'));
    }

    public function search(SearchFormRequest $request) {
        foreach (['Author', 'Category', 'Ingredient', 'Tag', 'Recipe'] as $cname) {
            $cname = ucfirst($cname);
            $class = "\\App\\Models\\{$cname}";

            foreach ($class::searchRecipes($request->term) as $result) {
                if ($cname === 'Recipe') {
                    $recipes[$result->id] = $result;
                } elseif ($cname === 'Ingredient') {
                    foreach ($result->ingredientDetail as $ingredientDetail) {
                        $recipes[$ingredientDetail->recipe->id] = $ingredientDetail->recipe;
                    }
                } else {
                    foreach ($result->recipes as $recipe) {
                        $recipes[$recipe->id] = $recipe;
                    }
                }
            }
        }

        if (isset($recipes)) {
            \Toast::clear();
            return view('search.results', compact('recipes'));
        } else {
            \Toast::info(__('toast.search.not_found'));
            return back();
        }
    }

    public function admin() {
        return view('user.admin');
    }
}
