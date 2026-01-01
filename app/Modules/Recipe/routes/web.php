<?php

use App\Modules\Recipe\Http\Controllers\CreateRecipeController;
use App\Modules\Recipe\Http\Controllers\DeleteRecipeController;
use App\Modules\Recipe\Http\Controllers\ListRecipesController;
use App\Modules\Recipe\Http\Controllers\UpdateRecipeController;
use App\Modules\Recipe\Http\Controllers\Web\RecipeIndexPage;
use Illuminate\Support\Facades\Route;

// API Routes
Route::middleware(['auth'])->prefix('recipe')->name('recipe.')->group(function () {
    Route::get('/', ListRecipesController::class)->name('index');
    Route::post('/', CreateRecipeController::class)->name('create');
    Route::patch('/{recipe}', UpdateRecipeController::class)->name('update');
    Route::delete('/{recipe}', DeleteRecipeController::class)->name('delete');
});

// Inertia Page Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/recipes', RecipeIndexPage::class)->name('recipes.index');
});
