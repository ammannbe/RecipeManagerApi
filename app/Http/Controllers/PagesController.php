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

    // TODO: move to API
    public function search($item, $term) {
        $cname = ucfirst($item);
        $class = '\\App\\' . $cname;
        $object = new $class;
        $results = $object->search($term);

        if ($results) {
            return $results;
        } else {
            abort(400);
        }
    }
}
