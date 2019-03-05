<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCookbook as CreateCookbookFormRequest;
use App\Helpers\FormHelper;
use App\Cookbook;
use Auth;

class CookbookController extends Controller
{
    public function createForm() {
        return view('cookbooks.create');
    }

    public function create(CreateCookbookFormRequest $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        if (Cookbook::create($input)) {
            \Toast::success('Kochbuch erfolgreich erstellt');
            return view('cookbooks.create');
        } else {
            abort(500);
        }
    }

    public function delete(Cookbook $cookbook) {
        if (Auth::user()->id === $cookbook->user_id) {
            if ($cookbook->delete()) {
                \Toast::success('Kochbuch erfolgreich gelöscht.');
                return redirect('/profile');
            } else {
                abort(500);
            }
        } else {
            \Toast::error('Du hast kein Recht dieses Kochbuch zu löschen.');
            return redirect('/profile');
        }
    }
}
