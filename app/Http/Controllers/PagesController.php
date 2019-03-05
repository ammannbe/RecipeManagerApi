<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Helpers\FormHelper;
use App\Http\Requests\Search as SearchFormRequest;

class PagesController extends Controller
{
    public function index() {
        $recipes = Recipe::orderBy('created_at', 'DESC')->paginate(10);
        return view('index', compact('recipes'));
    }

    public function searchForm($default = 'recipe') {
        $tables = [
            'author'        => 'Autoren',
            'category'      => 'Kategorien',
            'cookbook'      => 'Kochbücher',
            'recipe'        => 'Rezept / Zubereitung',
            'ingredient'    => 'Zutaten',
        ];
        return view('search.index', compact('tables', 'default'));
    }

    public function search(SearchFormRequest $request) {
        $cname   = ucfirst($request->item);
        $class   = '\\App\\' . $cname;
        $object  = new $class;
        $results = $object->search($request->term);

        foreach ($results as $result) {
            if ($cname == 'Recipe') {
                $recipes[$result->id] = $result;
            } elseif ($cname == 'Ingredient') {
                $recipe = $result->recipes;
                if (isset($recipe->id)) {
                    $recipes[$recipe->id] = $recipe;
                }
            } else {
                foreach ($result->recipes as $recipe) {
                    $recipes[$recipe->id] = $recipe;
                }
            }
        }

        if (isset($recipes)) {
            return view('index', compact('recipes'));
            \Toast::clear();
        } else {
            \Toast::info('Keine Rezepte gefunden.');
            return redirect('/search');
        }
    }
}
