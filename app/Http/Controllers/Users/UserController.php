<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\User\Update;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return auth()->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\User\Update  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->user()->delete();
    }
}
