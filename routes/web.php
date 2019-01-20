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
    Route::get('/cookbooks/create', 'CookbookController@createForm');
    Route::post('/cookbooks/create', 'CookbookController@create');

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

    Route::get('/rating-criteria/create', 'RatingCriterionController@createForm');
    Route::post('/rating-criteria/create', 'RatingCriterionController@create');

    Route::get('/user/edit', 'UserController@editForm');
    Route::post('/user/edit', 'UserController@edit');

});

Auth::routes(['verify' => true]);

Route::get('/profile', 'HomeController@index')->middleware('verified');

Route::get('/', 'PagesController@index');
Route::get('/recipes/{recipe}', 'RecipeController@show');
Route::get('/search', 'PagesController@searchForm');
Route::post('/search', 'PagesController@search');
