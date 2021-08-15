<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return response HTTP 201 with a Location header
     *
     * @see response()
     * @param  string  $routeName
     * @param  int  $resourceId
     * @param  mixed|null  $resource
     * @return \Illuminate\Http\Response
     */
    protected function responseCreated(string $routeName, int $resourceId, $resource = null)
    {
        return response($resource ?? '', 201)->header('Location', route($routeName, [$resourceId]));
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
