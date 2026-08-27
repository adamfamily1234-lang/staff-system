<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaffController;

Route::get('/departments/{department}/units', [StaffController::class, 'unitsByDepartment'])
    ->name('departments.units');
Route::resource('staff', StaffController::class);

Route::post(
    '/staff/{staff}/educations',
    [StaffController::class, 'storeEducation']
)->name('staff.educations.store');

Route::post(
    '/staff/{staff}/skills',
    [StaffController::class, 'storeSkill']
)->name('staff.skills.store');
