<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::get('refresh',[AuthController::class,'refresh']);
Route::get('logout',[AuthController::class,'logout']);
Route::get('user',[AuthController::class,'user']);

Route::get('categories/',[CategoryController::class,'index'])->middleware('auth');
Route::post('categories/',[CategoryController::class,'create'])->middleware('auth');
Route::delete('categories/{id}',[CategoryController::class,'delete'])->middleware('auth');

Route::get('movements/',[MovementController::class,'index'])->middleware('auth');
Route::post('movements/',[MovementController::class,'create'])->middleware('auth');
Route::delete('movements/{id}',[MovementController::class,'delete'])->middleware('auth');
