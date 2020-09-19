<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Users\User\Index;
use App\Http\Requests\Users\User\Store;
use App\Http\Requests\Users\User\Update;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Users\User\Index  $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Index $request)
    {
        $this->authorize(User::class);
        if ($request->trashed && auth()->user()->admin) {
            return User::withTrashed()->get();
        }
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\User\Store  $request
     * @return void
     */
    public function store(Store $request)
    {
        $this->authorize(User::class);
        $data = $request->validated();
        $user = User::make($data);

        event(new Registered($user));

        $user->author()->create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users\User|null  $user
     * @return \App\Models\Users\User
     */
    public function show(User $user = null)
    {
        $user = $user ?? auth()->user();
        $this->authorize($user);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\User\Update  $request
     * @param  \App\Models\Users\User|null  $user
     * @return void
     */
    public function update(Update $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        $this->authorize($user);
        $user->update($request->only(['email']));
        $user->author()->update($request->only(['name']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users\User|null  $user
     * @return void
     */
    public function destroy(User $user = null)
    {
        $user = $user ?? auth()->user();
        $this->authorize($user);
        $user->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->authorize($user);
        $user->restore();
    }
}
