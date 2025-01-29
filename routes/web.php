<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (accessible by all roles)
Route::middleware(['auth', 'role:admin,guru,siswa'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view($user->role . '.dashboard');
    })->name('dashboard');
});

// Admin-Specific Routes (only accessible by admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    
    Route::resource('users', UserController::class);
    Route::get('all-classes', [ClassController::class, 'index'])->name('admin.classes.index');
    Route::get('classes/create', [ClassController::class, 'create'])->name('admin.classes.create');
    Route::post('classes', [ClassController::class, 'store'])->name('admin.classes.store');
    Route::get('classes/{id}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
    Route::put('classes/{id}', [ClassController::class, 'update'])->name('admin.classes.update');
    Route::delete('classes/{id}', [ClassController::class, 'destroy'])->name('admin.classes.destroy');

});

// Guru-Specific Routes (only accessible by guru)
Route::middleware(['auth', 'role:guru'])->group(function () {
    // classes
    Route::get('classes', [ClassController::class, 'index'])->name('guru.classes.index');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('to-classes', [ClassController::class, 'index'])->name('siswa.classes.index');
    Route::post('classes/{id}/join', [ClassController::class, 'join'])->name('siswa.classes.join');
});
