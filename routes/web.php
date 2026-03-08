<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;



// (Homescreen)
Route::get('/', [HomeController::class, 'index'])->name('home');

// (Tampilan Form)
Route::get('/reservasi', [ReservationController::class, 'create'])->name('reservasi.create');

// Simpan Reservasi (Ketika tombol submit diklik)
Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
Route::get('/pembayaran/{id}', [ReservationController::class, 'showPayment'])->name('payment.show');


// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Group yang butuh login
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // CRUD Menu
        Route::resource('menus', MenuController::class);
        
        // CRUD Reservasi
        Route::resource('reservations', AdminReservationController::class);

        // Download Struk admin
        Route::get('/reservations/{id}/struk', [AdminReservationController::class, 'printStruk'])->name('reservations.struk');
        
        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // profile admin
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});