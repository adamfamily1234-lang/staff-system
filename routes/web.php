<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaffController;

Route::get('/departments/{department}/units', [StaffController::class, 'unitsByDepartment'])
    ->name('departments.units');

Route::get('/staff-seniority', [StaffController::class, 'seniority'])
    ->name('staff.seniority');
    
Route::resource('staff', StaffController::class);

Route::post(
    '/staff/{staff}/educations',
    [StaffController::class, 'storeEducation']
)->name('staff.educations.store');

Route::post(
    '/staff/{staff}/skills',
    [StaffController::class, 'storeSkill']
)->name('staff.skills.store');
Route::post(
    '/staff/{staff}/courses',
    [StaffController::class, 'storeCourse']
)->name('staff.courses.store');
Route::post(
    '/staff/{staff}/awards',
    [StaffController::class, 'storeAward']
)->name('staff.awards.store');
Route::post(
    '/staff/{staff}/placements',
    [StaffController::class, 'storePlacement']
)->name('staff.placements.store');