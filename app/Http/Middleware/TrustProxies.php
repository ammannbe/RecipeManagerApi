<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Repository $config)
    {
        if (!empty(config('app.trusted_proxies'))) {
            $this->proxies = config('app.trusted_proxies');
        }

        parent::__construct($config);
    }
}
