<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return response HTTP 201 with a Location header
     *
     * @see response()
     * @param  string  $routeName
     * @param  int  $resourceId
     * @return \Illuminate\Http\Response
     */
    protected function responseCreated(string $routeName, int $resourceId)
    {
        return response('', 201)->header('Location', route($routeName, [$resourceId]));
    }

    /**
     * Check if the current controller is enabled
     *
     * @return bool
     */
    public static function isEnabled()
    {
        return !(config('app.disabled_controllers')[static::class] ?? false);
    }
}
