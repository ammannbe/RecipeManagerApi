<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePrep as CreatePrepFormRequest;
use App\Helpers\FormHelper;
use App\Prep;
use Auth;

class PrepController extends Controller
{
    public function createForm() {
        return view('preps.create');
    }

    public function create(CreatePrepFormRequest $request) {
        if (Prep::create($request->all())) {
            \Toast::success('Vorbereitung erfolgreich erstellt');
            return view('preps.create');
        } else {
            abort(500);
        }
    }
}
