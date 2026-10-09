
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
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Publiskās lapas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Autorizēti lietotāji
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'not_blocked'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Lietotāja profils
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | Paroles maiņa
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile/password',
        [PasswordController::class, 'edit']
    )->name('password.edit');

    Route::put(
        '/profile/password',
        [PasswordController::class, 'update']
    )->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Mājdzīvnieki
    |--------------------------------------------------------------------------
    */

    Route::get('/pets', [PetController::class, 'index']);
    Route::get('/pets/create', [PetController::class, 'create']);
    Route::post('/pets', [PetController::class, 'store']);

    // Mājdzīvnieka rediģēšana
    Route::get(
        '/pets/{pet}/edit',
        [PetController::class, 'edit']
    )->name('pets.edit');

    Route::put(
        '/pets/{pet}',
        [PetController::class, 'update']
    )->name('pets.update');

    Route::delete('/pets/{pet}', [PetController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Pieskatītāju profili
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sitter-profile/create',
        [SitterProfileController::class, 'create']
    );

    Route::get(
        '/sitter-profile/edit',
        [SitterProfileController::class, 'create']
    );

    Route::post(
        '/sitter-profile',
        [SitterProfileController::class, 'store']
    );

    Route::get(
        '/sitter-profile',
        [SitterProfileController::class, 'show']
    );

    Route::get(
        '/sitters',
        [SitterProfileController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Rezervācijas
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/bookings',
        [BookingController::class, 'index']
    );

    Route::get(
        '/bookings/sitter',
        [BookingController::class, 'sitterBookings']
    );

    Route::get(
        '/bookings/create/{sitter}',
        [BookingController::class, 'create']
    );

    Route::post(
        '/bookings',
        [BookingController::class, 'store']
    );

    Route::post(
        '/bookings/{booking}/accept',
        [BookingController::class, 'accept']
    );

    Route::post(
        '/bookings/{booking}/reject',
        [BookingController::class, 'reject']
    );

    // Īpašnieks atceļ savu rezervāciju.
    Route::post(
        '/bookings/{booking}/cancel',
        [BookingController::class, 'cancel']
    );

    // Pieskatītājs atceļ savu pieņemto rezervāciju.
    Route::post(
        '/bookings/{booking}/sitter-cancel',
        [BookingController::class, 'sitterCancel']
    )->name('bookings.sitter-cancel');

    Route::post(
        '/bookings/{booking}/complete',
        [BookingController::class, 'complete']
    );

    /*
    |--------------------------------------------------------------------------
    | Sarakste
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/bookings/{booking}/messages',
        [MessageController::class, 'show']
    );

    Route::post(
        '/bookings/{booking}/messages',
        [MessageController::class, 'store']
    );

    /*
    |--------------------------------------------------------------------------
    | Atsauksmes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/bookings/{booking}/review',
        [ReviewController::class, 'create']
    );

    Route::post(
        '/bookings/{booking}/review',
        [ReviewController::class, 'store']
    );

    /*
    |--------------------------------------------------------------------------
    | Administratora panelis
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin',
        [AdminController::class, 'index']
    );

    Route::post(
        '/admin/users/{user}/toggle-block',
        [AdminController::class, 'toggleBlock']
    );

    Route::get(
        '/admin/bookings',
        [AdminController::class, 'bookings']
    );

    Route::get(
        '/admin/pets',
        [AdminController::class, 'pets']
    );

    Route::delete(
        '/admin/pets/{pet}',
        [AdminController::class, 'deletePet']
    );
});
