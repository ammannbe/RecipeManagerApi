<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \App\Recipe;
use Request;

class PagesController extends Controller
{
    public function index() {
        foreach (Recipe::orderBy('created_at', 'DESC')->take(10)->get() as $recipe) {
            $recipes[] = Recipe::setDetails($recipe);
        }

        return view('index', compact('recipes'));
    }

    public function searchForm() {
        $tables = [
            'author'        => 'Autoren',
            'category'      => 'Kategorien',
            'cookbook'      => 'Kochbücher',
            'recipe'        => 'Zubereitung',
            'ingredient'    => 'Zutaten',
        ];
        return view('search.index', compact('tables'));
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
        } else {
            \Toast::error('No recipes found');
            \Toast::info('No recipes found');
            return $this->searchForm();
        }
    }
}
