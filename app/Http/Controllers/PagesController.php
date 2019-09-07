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
    /**
     * Display a listing of the search results.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the search form.
     *
     * @param string $default = 'recipe'
     * @return \Illuminate\Http\Response
     */
    public function searchForm(string $default = 'recipe') {
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

    /**
     * Search the given term.
     *
     * @param  \App\Http\Requests\SearchFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchFormRequest $request) {
        foreach (['Author', 'Category', 'Ingredient', 'Tag', 'Recipe'] as $cname) {
            $cname = ucfirst($cname);
            $class = "\\App\\Models\\{$cname}";

            $terms = explode(' ', $request->term);

            foreach ($terms as $term) {
                foreach ($class::search($term)->get() as $result) {
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
        }

        if (isset($recipes) && count($recipes) === 1) {
            return redirect()->route('recipes.show', array_values($recipes)[0]->slug);
        } elseif (isset($recipes)) {
            \Toast::clear();
            return view('search.results', compact('recipes'));
        } else {
            \Toast::info(__('toast.search.not_found'));
            return back();
        }
    }


    /**
     * Show the admin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin() {
        return view('user.admin');
    }
}
