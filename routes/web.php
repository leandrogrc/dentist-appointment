<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('calendar.weekly');
    })->name('dashboard');

    // Calendar Routes
    Route::get('/calendar/weekly', [CalendarController::class, 'weekly'])->name('calendar.weekly');

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});



require __DIR__ . '/auth.php';
