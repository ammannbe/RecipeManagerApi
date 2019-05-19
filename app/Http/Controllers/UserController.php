<?php

namespace App\Http\Controllers;

use App\User;
use App\Recipe;
use Illuminate\Http\Request;
use App\Http\Requests\EditUser;
use Adldap\Laravel\Facades\Adldap;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::where('user_id', auth()->user()->id)->get();
        return view('user.index', compact('recipes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditUser  $request
     * @return \Illuminate\Http\Response
     */
    public function update(EditUser $request)
    {
        $user     = auth()->user();
        $ldapUser = Adldap::search()
            ->where(env('LDAP_USER_ATTRIBUTE'), '=', $user->username)
            ->first();

        if ($request->current_password) {
            if (in_array($request->current_password, $ldapUser->userPassword)) {
                $ldapUser->updateAttribute('userPassword', $request->new_password);
            } else {
                return redirect()->route('user.edit')
                    ->withErrors([__('toast.user.wrong_password')])
                    ->withInput();
            }
        }

        $user->name  = $ldapUser->cn   = $request->name;
        $user->email = $ldapUser->mail = $request->email;

        $ldapUser->save() && $user->update();
        \Toast::success(__('toast.user.updated'));

        return redirect()->route('user.index');
    }
}
