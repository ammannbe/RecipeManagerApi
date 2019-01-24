<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUser;
use App\Recipe;
use App\User;
use Auth;
use Hash;

class UserController extends Controller
{

    public function dashboard() {
        $recipes = Recipe::where('user_id', 51)->orderBy('cookbook_id')->get();
        return view('home', compact('recipes'));
    }
    
    public function editForm() {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function edit(EditUser $request) {
        if ($request->current_password) {
            if (Hash::check($request->current_password, Auth::user()->password)) {
                $input['password'] = $request->new_password;
            } else {
                $errorText = 'Falsches Passwort';
            }

            if (isset($errorText) && $errorText == TRUE) {
                return redirect('profile/edit')
                        ->withErrors([$errorText])
                        ->withInput();
            }
        }
        if ($request->name) {
            $input['name'] = $request->name;
        }
        if ($request->email) {
            $input['email'] = $request->email;
        }
        if (User::find(Auth::user()->id)->update($input)) {
            Toast::success('Profile erfolgreich aktualisiert.');
            return redirect('/profile');
        } else {
            return view('home');
        }
    }
}
