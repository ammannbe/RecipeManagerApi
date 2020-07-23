<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\User\Update;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \App\Models\Users\User
     */
    public function show()
    {
        if (!auth()->check()) {
            abort(401);
        }
        return auth()->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\User\Update  $request
     * @return void
     */
    public function update(Update $request)
    {
        $user = auth()->user();

        $user->update($request->only(['email']));
        $user->author()->update($request->only(['name']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function destroy()
    {
        auth()->user()->delete();
    }
}
