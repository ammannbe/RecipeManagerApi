<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Recipe;
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
        $tables = [
            'author'     => 'Verfasser',
            'category'   => 'Kategorien',
            'recipe'     => 'Rezept / Zubereitung',
            'ingredient' => 'Zutaten',
        ];
        return view('search.index', compact('tables', 'default'));
    }

    public function search(SearchFormRequest $request) {
        $cname   = ucfirst($request->item);
        $class   = '\\App\\' . $cname;
        $object  = new $class;
        $results = $object->searchRecipes($request->term);

        foreach ($results as $result) {
            if ($cname === 'Recipe') {
                $recipes[$result->id] = $result;
            } elseif ($cname === 'Ingredient') {
                foreach ($result->ingredientDetail as $ingredientDetail) {
                    $recipes[] = $ingredientDetail->recipe;
                }
            } else {
                foreach ($result->recipes as $recipe) {
                    $recipes[] = $recipe;
                }
            }
        }

        if (isset($recipes)) {
            \Toast::clear();
            return view('search.results', compact('recipes'));
        } else {
            \Toast::info(__('toast.search.not-found'));
            return back();
        }
    }

    public function admin() {
        return view('user.admin');
    }
}
