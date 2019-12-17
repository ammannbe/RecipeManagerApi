<?php

namespace App\Providers;

use App\Models\Recipes\Tag;
use App\Models\Users\Author;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\Category;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
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
        Category::observe('App\Observers\Recipes\CategoryObserver');
        Recipe::observe('App\Observers\Recipes\RecipeObserver');
        Tag::observe('App\Observers\Recipes\TagObserver');

        Author::observe('App\Observers\Users\AuthorObserver');
    }
}
