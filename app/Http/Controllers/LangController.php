<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function change(string $locale)
    {
        if (in_array($locale, config('app.locales'))) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
