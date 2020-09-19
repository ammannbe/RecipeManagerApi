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

Route::fallback('VueController');

Auth::routes(['verify' => true]);
Route::get('login', 'VueController')->name('login');
Route::get('register', 'VueController')->name('register');
Route::get('images/recipes/{recipe}/{name}', 'Recipes\RecipePhotoController@show');
