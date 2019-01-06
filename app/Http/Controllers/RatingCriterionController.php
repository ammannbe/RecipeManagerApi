<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RatingCriterionFormRequest;
use App\RatingCriterion;

class RatingCriterionController extends Controller
{


    public function createForm() {
        return view('ratingCriteria.create');
    }

    public function create(RatingCriterionFormRequest $request) {
        $input = $request->all();
        $ratingCriterion = RatingCriterion::create($input);
        if ($ratingCriterion->id) {
            \Toast::success('Kriterium erfolgreich erstellt');
            return view('ratingCriteria.create');
        } else {
            abort(500);
        }
    }
}
