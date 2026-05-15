<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('admin')->group(function () {
        Route::get('admin/bookings', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('admin/bookings/export', [AdminController::class, 'exportBookingsPdf'])->name('admin.bookings.export');
        Route::post('admin/bookings/{booking}', [AdminController::class, 'updateStatus'])->name('admin.booking.update');

        Route::post('admin/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
        Route::get('admin/rooms/{room}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::put('admin/rooms/{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('admin/rooms/{room}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');
    });
});
