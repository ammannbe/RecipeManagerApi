<?php

namespace App\Http\Controllers;

use \App\Recipe;

class PagesController extends Controller
{
    public function index() {
        foreach (Recipe::orderBy('created_at', 'DESC')->take(10)->get() as $recipe) {
            $recipes[] = Recipe::setDetails($recipe);
        }

        return view('index', compact('recipes'));
    }
}
