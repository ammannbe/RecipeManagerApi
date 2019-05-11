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

    Route::resource('recipes', 'RecipeController')->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);

    Route::resource('recipes.ratings', 'RatingController')->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);

    Route::resource('recipes.ingredient-details', 'IngredientDetailController')->only([
        'create', 'store', 'destroy'
    ]);

    Route::resource('import', 'ImportController')->only([
        'create', 'store',
    ]);

    Route::name('user.')->group(function () {
        Route::get('profile',  'UserController@index')->name('index');
        Route::get('profile/edit',   'UserController@edit')->name('edit');
        Route::put('profile/update', 'UserController@update')->name('update');
    });

    Route::get('/edit-mode', 'EditModeController@get');
    Route::get('/edit-mode/enable', 'EditModeController@enable');
    Route::get('/edit-mode/disable', 'EditModeController@disable');
});

Route::middleware('checklogin', 'checkadmin')->group(function() {

    Route::get('/admin', 'PagesController@admin')->name('admin.index');

    Route::resource('authors', 'AuthorController')->only([
        'create', 'store'
    ]);

    Route::resource('categories', 'CategoryController')->only([
        'create', 'store'
    ]);

    Route::resource('ingredients', 'IngredientController')->only([
        'create', 'store'
    ]);

    Route::resource('units', 'UnitController')->only([
        'create', 'store'
    ]);

    Route::resource('preps', 'PrepController')->only([
        'create', 'store'
    ]);

    Route::resource('rating-criteria', 'RatingCriterionController')->only([
        'create', 'store'
    ]);
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'PagesController@index')->name('home');

Route::get('/search', 'PagesController@searchForm')->name('search.index');
Route::post('/search', 'PagesController@search')->name('search.results');

Route::resource('recipes', 'RecipeController')->only(['show']);
