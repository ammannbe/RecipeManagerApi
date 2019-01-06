<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UnitFormRequest;
use App\Unit;

class UnitController extends Controller
{
    public function createForm() {
        return view('units.create');
    }

    public function create(UnitFormRequest $request) {
        $input = $request->all();
        $unit = Unit::create($input);
        if ($unit->id) {
            \Toast::success('Einheit erfolgreich erstellt');
            return view('units.create');
        } else {
            abort(500);
        }
    }
}
