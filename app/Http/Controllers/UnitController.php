<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUnit;

class UnitController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateUnit  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUnit $request)
    {
        Unit::create($request->all());
        \Toast::success(__('toast.unit.created'));

        return redirect()->route('admin.index');
    }
}
