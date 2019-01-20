<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recipes = Recipe::where('user_id', 51)->orderBy('cookbook_id')->get();
        return view('home', compact('recipes'));
    }
}
