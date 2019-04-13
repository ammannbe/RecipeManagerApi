<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use App\Recipe;
use App\Helpers\FormHelper;
use App\Http\Requests\EditUser as EditUserFormRequest;
use Adldap\Laravel\Facades\Adldap;

class UserController extends Controller
{

    public function dashboard() {
        $recipes = Recipe::where('user_id', auth()->user()->id)->get();
        return view('user.index', compact('recipes'));
    }

    public function editForm() {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    public function edit(EditUserFormRequest $request) {
        $user     = auth()->user();
        $ldapUser = Adldap::search()
            ->where(env('LDAP_USER_ATTRIBUTE'), '=', $user->username)
            ->first();

        if ($request->current_password) {
            if (in_array($request->current_password, $ldapUser->userPassword)) {
                $ldapUser->updateAttribute('userPassword', $request->new_password);
            } else {
                return redirect('profile/edit')
                    ->withErrors(['Falsches Passwort'])
                    ->withInput();
            }
        }

        $user->name  = $ldapUser->cn   = $request->name;
        $user->email = $ldapUser->mail = $request->email;

        $ldapUser->save() && $user->update();
        \Toast::success('Profil erfolgreich aktualisiert.');

        return redirect('/profile');
    }
}
