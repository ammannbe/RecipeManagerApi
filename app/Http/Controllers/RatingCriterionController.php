<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateRatingCriterion as CreateRatingCriterionFormRequest;
use App\Helpers\FormHelper;
use App\RatingCriterion;

class RatingCriterionController extends Controller
{
    public function createForm() {
        return view('ratingCriteria.create');
    }

    public function create(CreateRatingCriterionFormRequest $request) {
        if (RatingCriterion::create($request->all())) {
            \Toast::success('Kriterium erfolgreich erstellt');
            return view('ratingCriteria.create');
        } else {
            abort(500);
        }
    }
}
