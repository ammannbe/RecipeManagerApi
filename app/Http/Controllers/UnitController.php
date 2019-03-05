<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Helpers\FormHelper;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUnit as CreateUnitFormRequest;

class UnitController extends Controller
{
    public function createForm() {
        return view('units.create');
    }

    public function create(CreateUnitFormRequest $request) {
        if (Unit::create($request->all())) {
            \Toast::success('Einheit erfolgreich erstellt');
            return view('units.create');
        } else {
            abort(500);
        }
    }
}
