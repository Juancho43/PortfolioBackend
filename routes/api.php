<?php

use App\Http\Controllers\V1\EducationController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\TagsController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\LinkController;
use App\Http\Controllers\V1\WorkController;

use Illuminate\Support\Facades\Route;
use Pest\Plugins\Only;

Route::prefix('v1')->group(function () {
    // Rutas de autenticación
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');

    // Rutas públicas
    Route::group(['as' => 'public.'], function() {
        Route::resource('/profile', ProfileController::class)->names('profile');
        // Route::resource('/education', EducationController::class)->only(['index','show'])->names('education');
        Route::resource('/education', EducationController::class)->names('education');
        Route::resource('/project', ProjectController::class)->only(['index','show'])->names('project');
        Route::resource('/work', WorkController::class)->only(['index','show'])->names('work');
        Route::resource('/tag', TagsController::class)->only(['index','show'])->names('tag');
        Route::resource('/link', LinkController::class)->only(['index','show'])->names('link');

        // Relaciones y filtros
        Route::get('/project/education/{id}', [ProjectController::class, 'showByEducation'])->name('project.byEducation');
        Route::get('/project/tag/{id}', [ProjectController::class, 'showByTag'])->name('project.byTag');
        Route::get('/education/tag/{type}', [EducationController::class, 'showByType'])->name('education.byTag');
        Route::get('/work/tag/{id}', [WorkController::class, 'showByTag'])->name('work.byTag');
    });

    // Rutas privadas (requieren autenticación)
    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['as' => 'private.'], function() {
            Route::resource('/profile/private', ProfileController::class)->except(['index', 'show'])->names('profile');
            Route::resource('/education/private', EducationController::class)->except(['index', 'show'])->names('education');
            Route::resource('/project/private', ProjectController::class)->except(['index', 'show'])->names('project');
            Route::resource('/work/private', WorkController::class)->except(['index', 'show'])->names('work');
            Route::resource('/tag/private', TagsController::class)->except(['index', 'show'])->names('tag');
            Route::resource('/link/private', LinkController::class)->except(['index', 'show'])->names('link');

            // Gestión de archivos
            Route::post('/profile/img/{id}', [ProfileController::class, 'saveImg'])->name('profile.saveImage');
            Route::post('/profile/cv/{id}', [ProfileController::class, 'saveCv'])->name('profile.saveCV');
        });
    });
});

