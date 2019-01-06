<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUser;
use App\User;
use Auth;

class UserController extends Controller
{
    public function editForm() {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function edit(EditUser $request) {
        if ($request->current_password) {
            if ($request->current_password == Auth::user()->password) {
                if ($request->new_password == $request->new_password_verified) {
                    $input['password'] = $request->new_password;
                } else {
                    $errorText = 'Passwörter stimmen nicht überein';
                }
            } else {
                $errorText = 'Falsches Passwort';
            }

            if (isset($errorText) && $errorText == TRUE) {
                return redirect('user/edit')
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
            return redirect('/profile');
        } else {
            return view('home');
        }
    }
}
