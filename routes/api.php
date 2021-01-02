<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Recipes\TagController;
use App\Http\Controllers\Recipes\RecipeController;
use App\Http\Controllers\Ingredients\FoodController;
use App\Http\Controllers\Ingredients\UnitController;
use App\Http\Controllers\Recipes\CategoryController;
use App\Http\Controllers\Recipes\CookbookController;
use App\Http\Controllers\Recipes\RecipePhotoController;
use App\Http\Controllers\Ingredients\IngredientController;
use App\Http\Controllers\Ingredients\IngredientGroupController;
use App\Http\Controllers\Ingredients\IngredientAttributeController;

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

Route::apiResources([
    'foods' => 'Ingredients\FoodController',
    'ingredient-attributes' => 'Ingredients\IngredientAttributeController',

    'ratings' => 'Ratings\RatingController',
    'rating-criteria' => 'Ratings\RatingCriterionController',

    'categories' => 'Recipes\CategoryController',
    'recipes' => 'Recipes\RecipeController',
    'tags' => 'Recipes\TagController',
    'units' => 'Ingredients\UnitController',
], ['only' => ['index', 'show']]);

Route::apiResource('ingredients', 'Ingredients\IngredientController')->only(['show']);
Route::get('recipes/{recipe}/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');

Route::apiResource('ingredient-groups', 'Ingredients\IngredientGroupController')->only(['show']);
Route::get('recipes/{recipe}/ingredient-groups', [IngredientGroupController::class, 'index'])->name('ingredient-groups.index');

Route::get('recipes/{recipe}/pdf', [RecipeController::class, 'pdf']);


Route::middleware(['auth:api'])->group(function () {
    Route::get('user', [UserController::class, 'show'])->name('self.show');
});


Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::apiResources([
        'foods' => 'Ingredients\FoodController',
        'ingredient-attributes' => 'Ingredients\IngredientAttributeController',

        'ratings' => 'Ratings\RatingController',
        'rating-criteria' => 'Ratings\RatingCriterionController',

        'categories' => 'Recipes\CategoryController',
        'recipes' => 'Recipes\RecipeController',
        'tags' => 'Recipes\TagController',
        'units' => 'Ingredients\UnitController',
    ], ['only' => ['store', 'update', 'destroy']]);

    Route::apiResources([
        'ingredients' => 'Ingredients\IngredientController',
        'ingredient-groups' => 'Ingredients\IngredientGroupController',
    ], ['only' => ['update', 'destroy']]);

    Route::apiResource('cookbooks', 'Recipes\CookbookController');
    Route::apiResource('users', 'Users\UserController');


    Route::post('foods/{id}/restore', [FoodController::class, 'restore'])->name('foods.restore');
    Route::post('ingredient-attributes/{id}/restore', [IngredientAttributeController::class, 'restore'])->name('ingredient-attributes.restore');
    Route::post('ingredients/{id}/restore', [IngredientController::class, 'restore'])->name('ingredients.restore');
    Route::post('recipes/{recipe}/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::post('recipes/{recipe}/photos', [RecipePhotoController::class, 'store'])->name('recipe-photos.store');
    Route::delete('photos/{photo}', [RecipePhotoController::class, 'destroy'])->name('recipe-photos.destroy');
    Route::post('ingredient-groups/{id}/restore', [IngredientGroupController::class, 'restore'])->name('ingredient-groups.restore');
    Route::post('recipes/{recipe}/ingredient-groups', [IngredientGroupController::class, 'store'])->name('ingredient-groups.store');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::post('cookbooks/{id}/restore', [CookbookController::class, 'restore'])->name('cookbooks.restore');
    Route::post('recipes/{id}/restore', [RecipeController::class, 'restore'])->name('recipes.restore');
    Route::post('tags/{id}/restore', [TagController::class, 'restore'])->name('tags.restore');
    Route::post('units/{id}/restore', [UnitController::class, 'restore'])->name('units.restore');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');


    Route::patch('user', [UserController::class, 'update'])->name('self.update');
    Route::delete('user', [UserController::class, 'destroy'])->name('self.destroy');
});
