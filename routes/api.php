<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::get('refresh',[AuthController::class,'refresh']);
Route::get('logout',[AuthController::class,'logout']);
Route::get('user',[AuthController::class,'user']);
