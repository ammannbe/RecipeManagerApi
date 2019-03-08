<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangeEditMode;

class EditModeController extends Controller
{
    public function get() {
        return response()->json(session()->get('edit-mode'));
    }

    public function enable() {
        session(['edit-mode' => TRUE]);
    }

    public function disable() {
        session(['edit-mode' => FALSE]);
    }
}
