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

    Route::post('/recipes/import', 'ImportController@index');
    Route::get('/recipes/import', 'ImportController@form');

    Route::get('/ingredient-details/create/{recipe}', 'IngredientDetailController@createForm');
    Route::post('/ingredient-details/create/{recipe}', 'IngredientDetailController@create');
    Route::get('/ingredient-details/delete/{ingredientDetail}', 'IngredientDetailController@delete');

    Route::get('/ratings/add/{recipe}', 'RatingController@createForm');
    Route::post('/ratings/add/{recipe}', 'RatingController@create');
    Route::get('/ratings/edit/{rating}', 'RatingController@editForm');
    Route::post('/ratings/edit/{rating}', 'RatingController@edit');
    Route::get('/ratings/delete/{rating}', 'RatingController@delete');

    Route::get('/profile', 'UserController@dashboard');
    Route::get('/profile/edit', 'UserController@editForm');
    Route::post('/profile/edit', 'UserController@edit');

    Route::get('/edit-mode', 'EditModeController@get');
    Route::get('/edit-mode/enable', 'EditModeController@enable');
    Route::get('/edit-mode/disable', 'EditModeController@disable');
});

Route::middleware('checklogin', 'checkadmin')->group(function() {
    Route::get('/admin', 'PagesController@admin');

    Route::get('/authors/create', 'AuthorController@createForm');
    Route::post('/authors/create', 'AuthorController@create');

    Route::get('/categories/create', 'CategoryController@createForm');
    Route::post('/categories/create', 'CategoryController@create');

    Route::get('/ingredients/create', 'IngredientController@createForm');
    Route::post('/ingredients/create', 'IngredientController@create');

    Route::get('/units/create', 'UnitController@createForm');
    Route::post('/units/create', 'UnitController@create');

    Route::get('/preps/create', 'PrepController@createForm');
    Route::post('/preps/create', 'PrepController@create');

    Route::get('/rating-criteria/create', 'RatingCriterionController@createForm');
    Route::post('/rating-criteria/create', 'RatingCriterionController@create');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'PagesController@index');

Route::get('/search', 'PagesController@searchForm');
Route::post('/search', 'PagesController@search');

Route::get('/recipes/{recipe}', 'RecipeController@show');
