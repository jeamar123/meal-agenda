<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Meal\Http\Controllers\ListMealsController;
use App\Modules\Meal\Http\Controllers\CreateMealController;
use App\Modules\Meal\Http\Controllers\UpdateMealController;
use App\Modules\Meal\Http\Controllers\DeleteMealController;
use App\Modules\Meal\Http\Controllers\DuplicateMealController;
use App\Modules\Meal\Http\Controllers\Web\MealAgendaPage;

Route::get('/calendar', MealAgendaPage::class)->name('meal.index');
// Route::get('/', ListMealsController::class)->name('index');
Route::post('/', CreateMealController::class)->name('meal.create');
Route::patch('/{meal}', UpdateMealController::class)->name('meal.update');
Route::delete('/{meal}', DeleteMealController::class)->name('meal.delete');
Route::post('/{meal}/duplicate', DuplicateMealController::class)->name('meal.duplicate');

