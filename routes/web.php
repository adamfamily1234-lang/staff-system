<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaffController;

Route::get('/departments/{department}/units', [StaffController::class, 'unitsByDepartment'])
    ->name('departments.units');

Route::get('/staff-seniority', [StaffController::class, 'seniority'])
    ->name('staff.seniority');
    
Route::get('/staff/{staff}/educations/{education}/edit', [StaffController::class, 'editEducation'])
    ->name('staff.educations.edit');
Route::put('/staff/{staff}/educations/{education}', [StaffController::class, 'updateEducation'])
    ->name('staff.educations.update');
Route::delete('/staff/{staff}/educations/{education}', [StaffController::class, 'destroyEducation'])
    ->name('staff.educations.destroy');

Route::get('/staff/{staff}/skills/{skill}/edit', [StaffController::class, 'editSkill'])
    ->name('staff.skills.edit');
Route::put('/staff/{staff}/skills/{skill}', [StaffController::class, 'updateSkill'])
    ->name('staff.skills.update');
Route::delete('/staff/{staff}/skills/{skill}', [StaffController::class, 'destroySkill'])
    ->name('staff.skills.destroy');

Route::get('/staff/{staff}/courses/{course}/edit', [StaffController::class, 'editCourse'])
    ->name('staff.courses.edit');
Route::put('/staff/{staff}/courses/{course}', [StaffController::class, 'updateCourse'])
    ->name('staff.courses.update');
Route::delete('/staff/{staff}/courses/{course}', [StaffController::class, 'destroyCourse'])
    ->name('staff.courses.destroy');

Route::get('/staff/{staff}/awards/{award}/edit', [StaffController::class, 'editAward'])
    ->name('staff.awards.edit');
Route::put('/staff/{staff}/awards/{award}', [StaffController::class, 'updateAward'])
    ->name('staff.awards.update');
Route::delete('/staff/{staff}/awards/{award}', [StaffController::class, 'destroyAward'])
    ->name('staff.awards.destroy');

Route::get('/staff/{staff}/placements/{placement}/edit', [StaffController::class, 'editPlacement'])
    ->name('staff.placements.edit');
Route::put('/staff/{staff}/placements/{placement}', [StaffController::class, 'updatePlacement'])
    ->name('staff.placements.update');
Route::delete('/staff/{staff}/placements/{placement}', [StaffController::class, 'destroyPlacement'])
    ->name('staff.placements.destroy');

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