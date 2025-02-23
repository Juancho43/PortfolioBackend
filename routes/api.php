<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::resource('/education/private',EducationController::class)->except(['index','show']);
    Route::resource('/project/private',ProjectController::class)->except(['index','show']);;
    Route::resource('/tag/private',TagsController::class)->except(['index','show']);;
    Route::resource('/profile/private',ProfileController::class)->except(['index','show']);;
    Route::post('/profile/img/{id}',[ProfileController::class,'saveImg']);
    Route::post('/profile/cv/{id}',[ProfileController::class,'saveCv']);
});

Route::prefix('v1')->group(function () {
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login'])->name('login');


    Route::get('/education/proyects/{id}',[EducationController::class,'AllEducation']);
    Route::get('/project/tag/{id}',[ProjectController::class,'showByTag']);
    Route::get('/project/education/{id}',[ProjectController::class,'showByEducation']);
    Route::get('/education/type/{type}',[EducationController::class,'showByType']);

    Route::resource('/education',EducationController::class);
    Route::resource('/project',ProjectController::class);;
    Route::resource('/tag',TagsController::class);;
    Route::resource('/profile',ProfileController::class);;
});

