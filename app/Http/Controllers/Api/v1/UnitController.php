<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Unit;

class UnitController extends Controller
{
    public function index() {
        return Unit::all();
    }

    public function show(Unit $unit) {
        return $unit;
    }

    public function store(Request $request) {
        $unit = Unit::create($request->all());
        return response()->json($unit, 201);
    }

    public function update(Request $request, Unit $unit) {
        $unit->update($request->all());
        return response()->json($unit, 200);
    }

    public function delete(Unit $unit) {
        $unit->delete();
        return response()->json(null, 204);
    }
}
