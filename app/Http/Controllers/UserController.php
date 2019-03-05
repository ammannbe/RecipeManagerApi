<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use App\Recipe;
use App\Cookbook;
use App\Helpers\FormHelper;
use App\Http\Requests\EditUser as EditUserFormRequest;
use Adldap\Laravel\Facades\Adldap;

class UserController extends Controller
{

    public function dashboard() {
        $recipes   = Recipe::where('user_id', Auth::user()->id)->orderBy('cookbook_id')->get();
        $cookoobks = Cookbook::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('home', compact('recipes', 'cookoobks'));
    }

    public function editForm() {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function edit(EditUserFormRequest $request) {
        $ldapUser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', Auth::user()->username)->first();
        $user     = Auth::user();

        if ($request->current_password) {
            if (in_array($request->current_password, $ldapUser->userPassword)) {
                $ldapUser->updateAttribute('userPassword', $request->new_password);
                $passwordUpdated = TRUE;
            }

            if (!isset($passwordUpdated)) {
                return redirect('profile/edit')
                    ->withErrors(['Falsches Passwort'])
                    ->withInput();
            }
        }

        if ($request->name) {
            $user->name = $ldapUser->cn = $request->name;
        }

        if ($request->email) {
            $user->email = $ldapUser->mail = $request->email;
        }

        if ($ldapUser->save() && $user->update()) {
            \Toast::success('Profil erfolgreich aktualisiert.');
            return redirect('/profile');
        } else {
            return view('home');
        }
    }
}
