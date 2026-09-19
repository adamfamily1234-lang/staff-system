<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StructuredSkillController;
use App\Http\Controllers\ProfessionalContributionController;
use App\Http\Controllers\ProfessionalRecognitionController;
use App\Http\Controllers\HonoraryTitleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StructuredSkillAdminController;

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

Route::post(
    '/staff/{staff}/competencies',
    [StaffController::class, 'storeCompetency']
)->name('staff.competencies.store');

Route::get(
    '/staff/{staff}/competencies/{competency}/edit',
    [StaffController::class, 'editCompetency']
)->name('staff.competencies.edit');

Route::put(
    '/staff/{staff}/competencies/{competency}',
    [StaffController::class, 'updateCompetency']
)->name('staff.competencies.update');

Route::delete(
    '/staff/{staff}/competencies/{competency}',
    [StaffController::class, 'destroyCompetency']
)->name('staff.competencies.destroy');

Route::post(
    '/staff/{staff}/work-experiences',
    [StaffController::class, 'storeWorkExperience']
)->name('staff.work-experiences.store');

Route::get(
    '/staff/{staff}/work-experiences/{workExperience}/edit',
    [StaffController::class, 'editWorkExperience']
)->name('staff.work-experiences.edit');

Route::put(
    '/staff/{staff}/work-experiences/{workExperience}',
    [StaffController::class, 'updateWorkExperience']
)->name('staff.work-experiences.update');

Route::delete(
    '/staff/{staff}/work-experiences/{workExperience}',
    [StaffController::class, 'destroyWorkExperience']
)->name('staff.work-experiences.destroy');


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

// PENGIKTIRAFAN PROFESIONAL
Route::get(
    '/staff/{staff}/professional-recognitions/create',
    [ProfessionalRecognitionController::class, 'create']
)->name('staff.professional-recognitions.create');

Route::post(
    '/staff/{staff}/professional-recognitions',
    [ProfessionalRecognitionController::class, 'store']
)->name('staff.professional-recognitions.store');

Route::get(
    '/staff/{staff}/professional-recognitions/{professionalRecognition}/edit',
    [ProfessionalRecognitionController::class, 'edit']
)->name('staff.professional-recognitions.edit');

Route::put(
    '/staff/{staff}/professional-recognitions/{professionalRecognition}',
    [ProfessionalRecognitionController::class, 'update']
)->name('staff.professional-recognitions.update');

Route::delete(
    '/staff/{staff}/professional-recognitions/{professionalRecognition}',
    [ProfessionalRecognitionController::class, 'destroy']
)->name('staff.professional-recognitions.destroy');


// KURNIAAN / GELARAN KEHORMAT
Route::get(
    '/staff/{staff}/honorary-titles/create',
    [HonoraryTitleController::class, 'create']
)->name('staff.honorary-titles.create');

Route::post(
    '/staff/{staff}/honorary-titles',
    [HonoraryTitleController::class, 'store']
)->name('staff.honorary-titles.store');

Route::get(
    '/staff/{staff}/honorary-titles/{honoraryTitle}/edit',
    [HonoraryTitleController::class, 'edit']
)->name('staff.honorary-titles.edit');

Route::put(
    '/staff/{staff}/honorary-titles/{honoraryTitle}',
    [HonoraryTitleController::class, 'update']
)->name('staff.honorary-titles.update');

Route::delete(
    '/staff/{staff}/honorary-titles/{honoraryTitle}',
    [HonoraryTitleController::class, 'destroy']
)->name('staff.honorary-titles.destroy');

Route::get('/staff/{staff}/professional-contributions/create', [ProfessionalContributionController::class, 'create'])
    ->name('staff.professional-contributions.create');

Route::post('/staff/{staff}/professional-contributions', [ProfessionalContributionController::class, 'store'])
    ->name('staff.professional-contributions.store');

Route::get('/staff/{staff}/professional-contributions/{professionalContribution}/edit', [ProfessionalContributionController::class, 'edit'])
    ->name('staff.professional-contributions.edit');

Route::put('/staff/{staff}/professional-contributions/{professionalContribution}', [ProfessionalContributionController::class, 'update'])
    ->name('staff.professional-contributions.update');

Route::delete('/staff/{staff}/professional-contributions/{professionalContribution}', [ProfessionalContributionController::class, 'destroy'])
    ->name('staff.professional-contributions.destroy');

    Route::get(
    '/staff/{staff}/structured-skills/create',
    [StructuredSkillController::class, 'create']
)->name('staff.structured-skills.create');

Route::post(
    '/staff/{staff}/structured-skills',
    [StructuredSkillController::class, 'store']
)->name('staff.structured-skills.store');

Route::get(
    '/staff/{staff}/structured-skills/{structuredSkill}/edit',
    [StructuredSkillController::class, 'edit']
)->name('staff.structured-skills.edit');

Route::put(
    '/staff/{staff}/structured-skills/{structuredSkill}',
    [StructuredSkillController::class, 'update']
)->name('staff.structured-skills.update');

Route::delete(
    '/staff/{staff}/structured-skills/{structuredSkill}',
    [StructuredSkillController::class, 'destroy']
)->name('staff.structured-skills.destroy');


Route::middleware([
    'auth',
    'can:manage-structured-skills',
])->group(function () {

    Route::get(
        '/staff/{staff}/structured-skills-admin',
        [StructuredSkillAdminController::class, 'index']
    )->name('staff.structured-skills-admin.index');

    Route::get(
        '/staff/{staff}/structured-skills-admin/create',
        [StructuredSkillAdminController::class, 'create']
    )->name('staff.structured-skills-admin.create');

    Route::post(
        '/staff/{staff}/structured-skills-admin',
        [StructuredSkillAdminController::class, 'store']
    )->name('staff.structured-skills-admin.store');

    Route::get(
        '/staff/{staff}/structured-skills/{structuredSkill}/verify',
        [StructuredSkillAdminController::class, 'verifyForm']
    )->name('staff.structured-skills-admin.verify-form');

    Route::patch(
        '/staff/{staff}/structured-skills/{structuredSkill}/verify',
        [StructuredSkillAdminController::class, 'verify']
    )->name('staff.structured-skills-admin.verify');

    Route::get(
        '/staff/{staff}/structured-skills-admin/{structuredSkill}/edit',
        [StructuredSkillAdminController::class, 'edit']
    )->name('staff.structured-skills-admin.edit');

    Route::put(
        '/staff/{staff}/structured-skills-admin/{structuredSkill}',
        [StructuredSkillAdminController::class, 'update']
    )->name('staff.structured-skills-admin.update');

    Route::delete(
        '/staff/{staff}/structured-skills-admin/{structuredSkill}',
        [StructuredSkillAdminController::class, 'destroy']
    )->name('staff.structured-skills-admin.destroy');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
