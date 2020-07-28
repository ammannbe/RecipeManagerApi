<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class QueryLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.log_queries') === true) {
            $this->logQueries();
        }
    }

    /**
     * Listen and log DB Queries in the Laravel Log file
     *
     * @return void
     */
    protected function logQueries(): void
    {
        \DB::listen(function ($sql) {
            $query = $sql->sql;
            foreach ($sql->bindings as $key => $binding) {
                if ($key === array_key_first($sql->bindings)) {
                    $query = "{$query} [";
                }

                $query = "{$query}{$binding}, ";

                if ($key === array_key_last($sql->bindings)) {
                    $query = rtrim($query, ', ') . ']';
                }
            }

            $query = "{$query} ({$sql->time} ms)";

            \Log::debug($query);
        });
    }
}
