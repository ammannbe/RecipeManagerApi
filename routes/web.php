<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\VueController;
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

Route::get('images/recipes/{photo}/{name}', [RecipePhotoController::class, 'show']);
