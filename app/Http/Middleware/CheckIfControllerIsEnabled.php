<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfControllerIsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controller = $request->route()->controller;

        if (!method_exists($controller, 'isEnabled')) {
            return $next($request);
        }

        if (!$controller::isEnabled()) {
            abort(404);
        }

        return $next($request);
    }
}
