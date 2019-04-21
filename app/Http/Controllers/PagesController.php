<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Recipe;
use App\Helpers\FormHelper;
use App\Http\Requests\Search as SearchFormRequest;

class PagesController extends Controller
{
    public function index() {
        $newRecipes = Recipe::with(['category', 'author'])
            ->whereNotNull('photo')
            ->latest()
            ->paginate(4);

        $ratings = Rating::with(['recipe', 'ratingCriterion'])
            ->latest()
            ->paginate(4);

        $recipes = Recipe::with('category', 'author', 'ratings')
            ->whereNotNull('photo')
            ->get();

        $topRecipes = Recipe::best($recipes, 4);

        return view('index', compact('newRecipes', 'ratings', 'topRecipes'));
    }

    public function searchForm($default = 'recipe') {
        $tables = [
            'author'     => 'Autoren',
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
            return view('search.results', compact('recipes'));
            \Toast::clear();
        } else {
            \Toast::info('Keine Rezepte gefunden.');
            return redirect('/search');
        }
    }

    public function admin() {
        return view('user.admin');
    }
}
