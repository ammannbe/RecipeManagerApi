<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Prep;

class PrepController extends Controller
{
    public function index() {
        return Prep::all();
    }

    public function show(Prep $prep) {
        return $prep;
    }

    public function store(Request $request) {
        $prep = Prep::create($request->all());
        return response()->json($prep, 201);
    }

    public function update(Request $request, Prep $prep) {
        $prep->update($request->all());
        return response()->json($prep, 200);
    }

    public function delete(Prep $prep) {
        $prep->delete();
        return response()->json(null, 204);
    }
}
