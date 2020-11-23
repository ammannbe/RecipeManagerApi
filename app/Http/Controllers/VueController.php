<?php

namespace App\Http\Controllers;

/**
 * This is the default controller for the frontend
 *
 * Normally frontend routes fallback to this controller and are
 * managed by Vue.js (resources/js/routes.js).
 * There are so-called "named routes", which are listed explicitly (web.php).
 */
class VueController extends Controller
{
    /**
     * Return the default fallback view
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function __invoke()
    {
        return view('app');
    }
}
