<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CompanyController;

// Halaman Welcome (sebelum login)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Dashboard yang hanya bisa diakses pengguna yang sudah login dan diverifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Nested resource untuk posisi terkait perusahaan
    Route::resource('companies.positions', PositionController::class)
        ->middleware(\App\Http\Middleware\CheckCompanyAccess::class);

    // Resource routes untuk Pegawai, Kehadiran, dan Gaji
    Route::resource('employees', EmployeeController::class)
        ->middleware(\App\Http\Middleware\CheckCompanyAccess::class);
    Route::resource('attendances', AttendanceController::class)
        ->middleware(\App\Http\Middleware\CheckCompanyAccess::class);
    Route::resource('salaries', SalaryController::class)
        ->middleware(\App\Http\Middleware\CheckCompanyAccess::class);

    // Profil Perusahaan
    Route::get('/company/{company}', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company/{company}/update', [CompanyController::class, 'update'])->name('company.update');

    // Route untuk Profile (mengedit dan menghapus profil pengguna)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Require authentication routes (login, register, etc.)
require __DIR__ . '/auth.php';
