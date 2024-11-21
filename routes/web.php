<?php

use App\Http\Controllers\Backend\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Backend\Admin\RegisterController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Backend user
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->group(
    function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    }
);


// Backend admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(
    function () {
        Route::get('/dashboard', [AdminAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/register', [RegisterController::class, 'index'])->name('admin.register');
        Route::post('/store', [RegisterController::class, 'store'])->name('admin.store');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
