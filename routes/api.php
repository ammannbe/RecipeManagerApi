<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('status', 'Auth\LoginController@status');

    Route::middleware(['auth'])->group(function () {
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        Route::post('refresh', 'Auth\LoginController@refresh')->name('refresh');
    });

    Route::post('register', 'Auth\RegisterController@register')->name('register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password.confirm');
    Route::post('password/update', 'Auth\ResetPasswordController@reset')->name('password.update');
});


Route::apiResources([
    'ingredients' => 'Ingredients\IngredientController',
    'ingredient-attributes' => 'Ingredients\IngredientAttributeController',

    'ratings' => 'Ratings\RatingController',
    'rating-criteria' => 'Ratings\RatingCriterionController',

    'categories' => 'Recipes\CategoryController',
    'recipes' => 'Recipes\RecipeController',
    'tags' => 'Recipes\TagController',
    'units' => 'Ingredients\UnitController',
], ['only' => ['index', 'show']]);

Route::apiResource('ingredient-details', 'Ingredients\IngredientDetailController')->only(['show']);
Route::get('recipes/{recipe}/ingredient-details', 'Ingredients\IngredientDetailController@index')->name('ingredient-details.index');
Route::post('recipes/{recipe}/ingredient-details', 'Ingredients\IngredientDetailController@store')->name('ingredient-details.store');

Route::apiResource('ingredient-detail-groups', 'Ingredients\IngredientDetailGroupController')->only(['show']);
Route::get('recipes/{recipe}/ingredient-detail-groups', 'Ingredients\IngredientDetailGroupController@index')->name('ingredient-detail-groups.index');
Route::post('recipes/{recipe}/ingredient-detail-groups', 'Ingredients\IngredientDetailGroupController@store')->name('ingredient-detail-groups.store');


Route::middleware(['auth'])->group(function () {
    Route::apiResources([
        'ingredients' => 'Ingredients\IngredientController',
        'ingredient-attributes' => 'Ingredients\IngredientAttributeController',

        'ratings' => 'Ratings\RatingController',
        'rating-criteria' => 'Ratings\RatingCriterionController',

        'categories' => 'Recipes\CategoryController',
        'recipes' => 'Recipes\RecipeController',
        'tags' => 'Recipes\TagController',
        'units' => 'Ingredients\UnitController',
    ], ['only' => ['store', 'update', 'destroy']]);

    Route::apiResources([
        'ingredient-details' => 'Ingredients\IngredientDetailController',
        'ingredient-detail-groups' => 'Ingredients\IngredientDetailGroupController',
    ], ['only' => ['update', 'destroy']]);

    Route::apiResource('cookbooks', 'Recipes\CookbookController');


    Route::post('ingredients/{id}/restore', 'Ingredients\IngredientController@restore')->name('ingredients.restore');
    Route::post('ingredient-attributes/{id}/restore', 'Ingredients\IngredientAttributeController@restore')->name('ingredient-attributes.restore');
    Route::post('ingredient-details/{id}/restore', 'Ingredients\IngredientDetailController@restore')->name('ingredient-details.restore');
    Route::post('ingredient-detail-groups/{id}/restore', 'Ingredients\IngredientDetailGroupController@restore')->name('ingredient-detail-groups.restore');
    Route::post('categories/{id}/restore', 'Recipes\CategoryController@restore')->name('categories.restore');
    Route::post('cookbooks/{id}/restore', 'Recipes\CookbookController@restore')->name('cookbooks.restore');
    Route::post('recipes/{id}/restore', 'Recipes\RecipeController@restore')->name('recipes.restore');
    Route::post('tags/{id}/restore', 'Recipes\TagController@restore')->name('tags.restore');
    Route::post('units/{id}/restore', 'Ingredients\UnitController@restore')->name('units.restore');


    Route::get('user', 'Users\UserController@show')->name('user.show');
    Route::patch('user', 'Users\UserController@update')->name('user.update');
    Route::delete('user', 'Users\UserController@destroy')->name('user.destroy');
});
