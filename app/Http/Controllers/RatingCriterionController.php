<?php

namespace App\Http\Controllers;

use App\RatingCriterion;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRatingCriterion;

class RatingCriterionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ratingCriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateRatingCriterion  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRatingCriterion $request)
    {
        RatingCriterion::create($request->all());
        \Toast::success(__('toast.rating_criterion.created'));

        return view('ratingCriteria.create');
    }
}
