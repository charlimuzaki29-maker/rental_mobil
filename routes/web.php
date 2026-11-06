<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Rental Mobil / Kendaraan
|--------------------------------------------------------------------------
*/

// ===================== Modul Pelanggan (Publik) =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/{car}', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/{rental}/success', [BookingController::class, 'success'])->name('success');
});

// ===================== Modul Autentikasi Admin =====================
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// ===================== Modul Admin (Wajib Login) =====================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Armada Mobil (CRUD + Upload Foto)
    Route::resource('cars', AdminCarController::class)->except(['show']);

    // Manajemen Transaksi Sewa (Lihat, Detail & Ubah Status 'Disewa', 'Selesai', 'Batal')
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{rental}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::patch('/rentals/{rental}/status', [AdminRentalController::class, 'updateStatus'])->name('rentals.status');
});
