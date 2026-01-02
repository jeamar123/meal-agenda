<?php

use Illuminate\Support\Facades\Route;

use App\Modules\User\Http\Controllers\Web\LoginPage;
use App\Modules\User\Http\Controllers\Web\LoginController;

Route::group(['middleware' => ['guest']], function () {
  Route::get('/login', LoginPage::class)->name('login.show');
  Route::post('/login', LoginController::class)->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('meal.index');
    });
});