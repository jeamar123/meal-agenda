<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Meal\Http\Controllers\ListMealsByDateController;
use App\Modules\Meal\Http\Controllers\CreateMealController;
use App\Modules\Meal\Http\Controllers\UpdateMealController;
use App\Modules\Meal\Http\Controllers\DeleteMealController;
use App\Modules\Meal\Http\Controllers\DuplicateMealController;

Route::middleware(['auth'])->prefix('meal')->name('meal.')->group(function () {
    Route::get('/', ListMealsByDateController::class)->name('index');
    Route::post('/', CreateMealController::class)->name('create');
    Route::patch('/{meal}', UpdateMealController::class)->name('update');
    Route::delete('/{meal}', DeleteMealController::class)->name('delete');
    Route::post('/{meal}/duplicate', DuplicateMealController::class)->name('duplicate');
});
