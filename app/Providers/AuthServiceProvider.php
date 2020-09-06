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
        'App\Models\Ingredients\Food' => 'App\Policies\Ingredients\FoodPolicy',
        'App\Models\Ingredients\IngredientGroup' => 'App\Policies\Ingredients\IngredientGroupPolicy',
        'App\Models\Ingredients\Ingredient' => 'App\Policies\Ingredients\IngredientPolicy',
        'App\Models\Ingredients\IngredientAttribute' => 'App\Policies\Ingredients\IngredientAttributePolicy',
        'App\Models\Ingredients\Unit' => 'App\Policies\Ingredients\UnitPolicy',

        'App\Models\Ratings\RatingCriterion' => 'App\Policies\Ratings\RatingCriterionPolicy',
        'App\Models\Ratings\Rating' => 'App\Policies\Ratings\RatingPolicy',

        'App\Models\Recipes\Category' => 'App\Policies\Recipes\CategoryPolicy',
        'App\Models\Recipes\Cookbook' => 'App\Policies\Recipes\CookbookPolicy',
        'App\Models\Recipes\Recipe' => 'App\Policies\Recipes\RecipePolicy',
        'App\Models\Recipes\Tag' => 'App\Policies\Recipes\TagPolicy',

        'App\Models\Users\Author' => 'App\Policies\Users\AuthorPolicy',
        'App\Models\Users\User' => 'App\Policies\Users\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
