<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaffController;

Route::get('/departments/{department}/units', [StaffController::class, 'unitsByDepartment'])
    ->name('departments.units');
Route::resource('staff', StaffController::class);
