<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCookbook;
use App\Helpers\FormHelper;
use App\Cookbook;
use Auth;

class CookbookController extends Controller
{
    public function createForm() {
        return view('cookbooks.create');
    }

    public function create(CreateCookbook $request) {
        $request->merge(['user_id' => auth()->user()->id]);
        Cookbook::create($request->all());
        \Toast::success('Kochbuch erfolgreich erstellt');

        return view('cookbooks.create');
    }

    public function delete(Cookbook $cookbook) {
        $cookbook->delete();
        \Toast::success('Kochbuch erfolgreich gelöscht.');

        return redirect('/profile');
    }
}
