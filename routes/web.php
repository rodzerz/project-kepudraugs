<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\SitterProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/pets', [PetController::class, 'index']);
    Route::get('/pets/create', [PetController::class, 'create']);
    Route::post('/pets', [PetController::class, 'store']);

    Route::delete('/pets/{pet}', [PetController::class, 'destroy']);

});

Route::middleware('auth')->group(function () {

    Route::get('/sitter-profile/create', [SitterProfileController::class, 'create']);
    Route::post('/sitter-profile', [SitterProfileController::class, 'store']);
    Route::get('/sitter-profile', [SitterProfileController::class, 'show']);
    Route::get('/sitters', [SitterProfileController::class, 'index']);

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);

});

Route::get('/bookings', [BookingController::class, 'index'])
    ->middleware('auth');

Route::get('/bookings/sitter', [BookingController::class, 'sitterBookings'])
    ->middleware('auth');

Route::get('/bookings/create/{sitter}', [BookingController::class, 'create'])
    ->middleware('auth');

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('auth');

Route::post('/bookings/{booking}/accept', [BookingController::class, 'accept'])
    ->middleware('auth');

Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])
    ->middleware('auth');

Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
    ->middleware('auth');

Route::get('/bookings/{booking}/messages', [MessageController::class, 'show'])
    ->middleware('auth');

Route::post('/bookings/{booking}/messages', [MessageController::class, 'store'])
    ->middleware('auth');

Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])
    ->middleware('auth');

Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])
    ->middleware('auth');

Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])
    ->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth');

Route::post('/admin/users/{user}/toggle-block', [AdminController::class, 'toggleBlock'])
    ->middleware('auth');

Route::get('/admin/bookings', [AdminController::class, 'bookings'])
    ->middleware('auth');
    
    Route::get('/admin/pets', [AdminController::class, 'pets'])
    ->middleware('auth');

Route::delete('/admin/pets/{pet}', [AdminController::class, 'deletePet'])
    ->middleware('auth');