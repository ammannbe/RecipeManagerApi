<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('checklogin')->group(function() {
    Route::get('/recipes/create', 'RecipeController@createForm');
    Route::post('/recipes/create', 'RecipeController@create');
    Route::get('/recipes/edit/{recipe}', 'RecipeController@editForm');
    Route::post('/recipes/edit/{recipe}', 'RecipeController@edit');
    Route::get('/recipes/delete/{recipe}', 'RecipeController@delete');

    Route::get('/ingredients/add/{recipe}', 'IngredientDetailController@createForm');
    Route::post('/ingredients/add/{recipe}', 'IngredientDetailController@create');
    Route::get('/ingredients/delete/{ingredientDetail}', 'IngredientDetailController@delete');

    Route::get('/ratings/add/{recipe}', 'RatingController@createForm');
    Route::post('/ratings/add/{recipe}', 'RatingController@create');
    Route::get('/ratings/delete/{rating}', 'RatingController@delete');

    Route::get('/user/edit', 'UserController@editForm');
    Route::post('/user/edit', 'UserController@edit');
});

Route::get('/', 'PagesController@index');
Route::get('/recipes/{recipe}', 'RecipeController@show');
Route::get('/search', 'PagesController@searchForm');
Route::post('/search', 'PagesController@search');


/* User & Auth */
Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');

Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');

Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');
