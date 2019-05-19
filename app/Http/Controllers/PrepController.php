<?php

namespace App\Http\Controllers;

use App\Prep;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePrep;

class PrepController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('preps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreatePrep  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrep $request)
    {
        Prep::create($request->all());
        \Toast::success(__('toast.prep.created'));

        return redirect()->route('admin.index');
    }
}
