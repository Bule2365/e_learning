<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
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

    // User management routes
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::resource('users', UserController::class);

    // Class management routes
    Route::get('all-classes', [ClassController::class, 'index'])->name('admin.classes.index');
    Route::get('classes/create', [ClassController::class, 'create'])->name('admin.classes.create');
    Route::post('classes', [ClassController::class, 'store'])->name('admin.classes.store');
    Route::get('admin/classes/{id}/show', [ClassController::class, 'show'])->name('admin.classes.show');
    Route::post('admin/classes/{classId}/addStudent', [ClassController::class, 'addStudentToClass'])->name('admin.classes.addStudentToClass');
    Route::post('admin/classes/{classId}/removeStudent', [ClassController::class, 'removeStudentFromClass'])->name('admin.classes.removeStudentFromClass');
    Route::get('classes/{id}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
    Route::put('classes/{id}', [ClassController::class, 'update'])->name('admin.classes.update');
    Route::delete('classes/{id}', [ClassController::class, 'destroy'])->name('admin.classes.destroy');

    // Subject management routes
    Route::resource('subjects', SubjectController::class);
});

// Guru-Specific Routes (only accessible by guru)
Route::middleware(['auth', 'role:guru'])->group(function () {
    // Class management routes for Guru
    Route::get('classes', [ClassController::class, 'index'])->name('guru.classes.index');

    // Task management routes for Guru
    Route::resource('tasks', TaskController::class);
    Route::put('/tasks/{task}/students/{user}/update-score', [TaskController::class, 'updateScore'])->name('tasks.updateScore');

    // Exam management for guru
    Route::get('/exams', [ExamController::class, 'index'])->name('guru.exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('guru.exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('guru.exams.store');
    Route::get('/exams/{id}/add-questions', [ExamController::class, 'addQuestions'])->name('guru.exams.add_questions');
    Route::post('/exams/{id}/add-questions', [ExamController::class, 'storeQuestions'])->name('guru.exams.store_questions');
    Route::get('/guru/exams/{id}', [ExamController::class, 'show'])->name('guru.exams.show');
});

// Siswa-Specific Routes (only accessible by siswa)
Route::middleware(['auth', 'role:siswa'])->group(function () {
    // Class routes for Siswa
    Route::get('to-classes', [ClassController::class, 'index'])->name('siswa.classes.index');
    Route::post('classes/{id}/join', [ClassController::class, 'join'])->name('siswa.classes.join');

    // Task routes for Siswa
    Route::get('/tasks-student', [TaskStudentController::class, 'index'])->name('student.tasks.index');
    Route::get('/detail-tasks/{task}', [TaskStudentController::class, 'show'])->name('student.tasks.show');
    Route::post('/post-tasks/{task}/submit', [TaskStudentController::class, 'submit'])->name('student.tasks.submit');
});
