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

Route::get('category',[CategoryController::class,'index'])->middleware('auth');
Route::post('category',[CategoryController::class,'create'])->middleware('auth');

Route::get('movement',[MovementController::class,'index'])->middleware('auth');
Route::post('movement',[MovementController::class,'create'])->middleware('auth');
