<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateRatingCriterion;
use App\Helpers\FormHelper;
use App\RatingCriterion;

class RatingCriterionController extends Controller
{
    public function createForm() {
        return view('ratingCriteria.create');
    }

    public function create(CreateRatingCriterion $request) {
        RatingCriterion::create($request->all());
        \Toast::success(__('toast.rating-criterion.created'));

        return view('ratingCriteria.create');
    }
}
