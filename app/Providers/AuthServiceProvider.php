<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\IngredientDetail' => 'App\Policies\IngredientDetailPolicy',
        'App\Models\Rating'           => 'App\Policies\RatingPolicy',
        'App\Models\Recipe'           => 'App\Policies\RecipePolicy',
        'App\Models\Author'           => 'App\Policies\AuthorPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
