<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectController;
use App\Http\Controllers\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::resource('/education',EducationController::class);
Route::resource('/proyect',ProyectController::class);
Route::resource('/tag',TagsController::class);
Route::resource('/profile',ProfileController::class);