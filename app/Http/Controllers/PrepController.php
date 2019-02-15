<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PrepFormRequest;
use App\Helpers\FormHelper;
use App\Prep;
use Auth;

class PrepController extends Controller
{
    public function createForm() {
        return view('preps.create');
    }

    public function create(PrepFormRequest $request) {
        $input = $request->all();
        $prep = Prep::create($input);
        if ($prep->id) {
            \Toast::success('Vorbereitung erfolgreich erstellt');
            return view('preps.create');
        } else {
            abort(500);
        }
    }
}
