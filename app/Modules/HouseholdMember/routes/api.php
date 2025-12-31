<?php

use Illuminate\Support\Facades\Route;
use App\Modules\HouseholdMember\Http\Controllers\ListHouseholdMembersController;
use App\Modules\HouseholdMember\Http\Controllers\CreateHouseholdMemberController;
use App\Modules\HouseholdMember\Http\Controllers\UpdateHouseholdMemberController;
use App\Modules\HouseholdMember\Http\Controllers\DeleteHouseholdMemberController;

Route::middleware(['auth:sanctum'])->prefix('household-member')->name('household-member.')->group(function () {
    Route::get('/', ListHouseholdMembersController::class)->name('index');
    Route::post('/', CreateHouseholdMemberController::class)->name('create');
    Route::patch('/{householdMember}', UpdateHouseholdMemberController::class)->name('update');
    Route::delete('/{householdMember}', DeleteHouseholdMemberController::class)->name('delete');
});
