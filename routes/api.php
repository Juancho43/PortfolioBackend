<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login'])->name('login');

// Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
Route::prefix('v1')->group(function () {
    Route::get('/education/proyects/{id}',[EducationController::class,'AllEducation']);
    Route::get('/project/tag/{id}',[ProyectController::class,'showByTag']);
    Route::get('/project/education/{id}',[ProyectController::class,'showByEducation']);
    Route::resource('/education',EducationController::class);
    Route::resource('/project',ProyectController::class);
    Route::resource('/tag',TagsController::class);
    Route::resource('/profile',ProfileController::class);
});

