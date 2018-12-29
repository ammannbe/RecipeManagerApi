<?php

use Illuminate\Http\Request;

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

/* Use App\Author; */

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

/* 
Route::middleware('auth:api', 'throttle:120,1')->group(function() {

    // NOTE: https://laravel.com/docs/4.2/controllers#restful-resource-controllers
    Route::get('authors', 'AuthorController@index');
    Route::get('authors/{author}', 'AuthorController@show');
    Route::post('authors', 'AuthorController@store');
    Route::put('authors/{author}', 'AuthorController@update');
    Route::delete('authors/{author}', 'AuthorController@delete');

    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category}', 'CategoryController@show');
    Route::post('categories', 'CategoryController@store');
    Route::put('categories/{category}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@delete');

    Route::get('ingredients', 'IngredientController@index');
    Route::get('ingredients/{ingredient}', 'IngredientController@show');
    Route::post('ingredients', 'IngredientController@store');
    Route::put('ingredients/{ingredient}', 'IngredientController@update');
    Route::delete('ingredients/{ingredient}', 'IngredientController@delete');

    Route::get('prep', 'PrepController@index');
    Route::get('prep/{ingredient}', 'PrepController@show');
    Route::post('prep', 'PrepController@store');
    Route::put('prep/{ingredient}', 'PrepController@update');
    Route::delete('prep/{ingredient}', 'PrepController@delete');

    Route::get('ratings', 'RatingController@index');
    Route::get('ratings/{rating}', 'RatingController@show');
    Route::post('ratings', 'RatingController@store');
    Route::put('ratings/{rating}', 'RatingController@update');
    Route::delete('ratings/{rating}', 'RatingController@delete');
    
    Route::get('recipes', 'RecipeController@index');
    Route::get('recipes/{recipe}', 'RecipeController@show');
    Route::post('recipes', 'RecipeController@store');
    Route::put('recipes/{recipe}', 'RecipeController@update');
    Route::delete('recipes/{recipe}', 'RecipeController@delete');

    Route::get('rating-criteria', 'RatingCriterionController@index');
    Route::get('rating-criteria/{criterion}', 'RatingCriterionController@show');
    Route::post('rating-criteria', 'RatingCriterionController@store');
    Route::delete('rating-criteria/{criterion}', 'RatingCriterionController@delete');

    Route::get('units', 'UnitController@index');
    Route::get('units/{unit}', 'UnitController@show');
    Route::post('units', 'UnitController@store');
    Route::put('units/{unit}', 'UnitController@update');
    Route::delete('units/{unit}', 'UnitController@delete');

    //.... not finished
});
 */