<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recipes\RecipePhotoController;

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

Route::get('login', 'VueController')->name('login');
Route::get('register', 'VueController')->name('register');
Route::get('password/reset/{token}', 'VueController')->name('password.reset');
Route::get('images/recipes/{photo}/{name}', [RecipePhotoController::class, 'show']);
