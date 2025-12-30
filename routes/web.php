<?php

use Illuminate\Support\Facades\Route;

use App\Modules\User\Http\Controllers\Web\LoginPage;
use App\Modules\User\Http\Controllers\Web\LoginController;
use App\Http\Controllers\CalendarPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::group(['middleware' => ['auth']], function () {
//   Route::get('/', DashboardPage::class)->name('dashboard.index');
//   Route::get('/logout', LogoutController::class)->name('admin.logout');
// });

Route::group(['middleware' => ['guest']], function () {
  Route::get('/login', LoginPage::class)->name('login.show');
  Route::post('/login', LoginController::class)->name('user.login');
});

Route::group(['middleware' => ['auth']], function () {
  Route::get('/', CalendarPage::class)->name('calendar.index');
});