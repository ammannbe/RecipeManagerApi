<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \App\Recipe;
use Request;

class PagesController extends Controller
{
    public function index() {
        $recipes = Recipe::orderBy('created_at', 'DESC')->paginate(10);
        return view('index', compact('recipes'));
    }

    public function searchForm($default = NULL) {
        $tables = [
            'author'        => 'Autoren',
            'category'      => 'Kategorien',
            'cookbook'      => 'Kochbücher',
            'recipe'        => 'Rezept / Zubereitung',
            'ingredient'    => 'Zutaten',
        ];
        return view('search.index', compact('tables', 'default'));
    }

    public function search() {
        $input = Request::all();
        $cname = ucfirst($input['table']);
        $class = '\\App\\' . $cname;
        $object = new $class;
        $results = $object->search($input['term']);
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
            \Toast::info('No recipes found');
            return $this->searchForm($input['table']);
        }
    }
}
