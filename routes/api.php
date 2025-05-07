<?php

use App\Http\Controllers\V1\EducationController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\TagsController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\LinkController;
use App\Http\Controllers\V1\WorkController;

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Rutas de autenticación
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    // Rutas públicas
    Route::group(['as' => 'public.'], function() {
        Route::resource('/profile', ProfileController::class)->names('profile');
        Route::resource('/education', EducationController::class)->only(['index','show'])->names('education');
        Route::resource('/project', ProjectController::class)->only(['index','show'])->names('project');
        Route::resource('/work', WorkController::class)->only(['index','show'])->names('work');
        Route::resource('/tag', TagsController::class)->only(['index','show'])->names('tag');
        Route::resource('/link', LinkController::class)->only(['index','show'])->names('link');

        // Relaciones y filtros
        Route::get('/project/education/{slug}', [ProjectController::class, 'getByEducation'])->name('project.byEducation');
        Route::get('/project/tag/{tag}', [ProjectController::class, 'getByTag'])->name('project.byTag');
        Route::get('/education/tag/{tag}', [EducationController::class, 'getByTag'])->name('education.byTag');
        Route::get('/work/tag/{tag}', [WorkController::class, 'getByTag'])->name('work.byTag');

        // Add these routes under the public group
        Route::get('/education/slug/{slug}', [EducationController::class, 'getBySlug'])->name('education.bySlug');
        Route::get('/work/slug/{slug}', [WorkController::class, 'getBySlug'])->name('work.bySlug');
        Route::get('/project/slug/{slug}', [ProjectController::class, 'getBySlug'])->name('project.bySlug');

        Route::get('/tag/from/project', [TagsController::class, 'getAllProjectTags'])->name('tag.projects');
        Route::get('/tag/from/work', [TagsController::class, 'getAllWorkTags'])->name('tag.works');
        Route::get('/tag/from/education', [TagsController::class, 'getAllEducationTags'])->name('tag.education');



    });

    // Rutas privadas (requieren autenticación)
    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['as' => 'private.'], function(){
            Route::resource('/profile/private', ProfileController::class)->only(['store', 'update', 'destroy'])->names('profile');
            Route::resource('/work/private',    WorkController::class)->only(['store', 'update', 'destroy'])->names('work');
            Route::resource('/education/private', EducationController::class)->only(['store', 'update', 'destroy'])->names('education');
            Route::resource('/project/private', ProjectController::class)->only(['store', 'update', 'destroy'])->names('project');
            Route::resource('/tag/private', TagsController::class)->only(['store', 'update', 'destroy'])->names('tag');
            Route::resource('/link/private', LinkController::class)->only(['store', 'update', 'destroy'])->names('link');

            //Buscadores
            Route::get('/tag/search', [TagsController::class, 'search'])->name('tag.search');
            Route::get('/project/search', [ProjectController::class, 'search'])->name('tag.search');
            // Gestión de archivos
            Route::post('/profile/img/{id}', [ProfileController::class, 'saveImg'])->name('profile.saveImage');
            Route::post('/profile/cv/{id}', [ProfileController::class, 'saveCv'])->name('profile.saveCV');
        });
    });
});

