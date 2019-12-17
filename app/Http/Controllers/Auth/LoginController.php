<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\Login;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Show the login Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  \App\Http\Requests\Auth\Login  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request)
    {
        $token = auth()->attempt($request->validated());

        if (!$token) {
            abort(401);
        }

        return $this->responseWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->responseWithToken(auth()->refresh());
    }

    /**
     * Check if user is authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function status()
    {
        if (!auth()->check()) {
            abort(401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'issued_at' => now(),
            'expires_at' => now()->addMinutes(auth()->factory()->getTTL()),
        ]);
    }
}
