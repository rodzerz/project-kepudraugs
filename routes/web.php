<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\SitterProfileController;
use App\Http\Controllers\BookingController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');


Route::middleware('auth')->group(function () {

    Route::get('/pets', [PetController::class, 'index']);
    Route::get('/pets/create', [PetController::class, 'create']);
    Route::post('/pets', [PetController::class, 'store']);

});


Route::middleware('auth')->group(function () {

    Route::get('/sitter-profile/create', [SitterProfileController::class, 'create']);
    Route::post('/sitter-profile', [SitterProfileController::class, 'store']);
    Route::get('/sitter-profile', [SitterProfileController::class, 'show']);
    Route::get('/sitters', [SitterProfileController::class, 'index']);

});


Route::get('/bookings/create/{sitter}', [BookingController::class, 'create'])
    ->middleware('auth');

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('auth');