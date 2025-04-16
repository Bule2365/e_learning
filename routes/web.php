<?php

use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StudentMaterialController;
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

// Dashboard Redirect Based on Role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role == 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    });
});

// Admin-Specific Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User Management
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::resource('users', UserController::class);

    // Class Management
    Route::get('all-classes', [ClassController::class, 'index'])->name('admin.classes.index');
    Route::get('classes/create', [ClassController::class, 'create'])->name('admin.classes.create');
    Route::post('classes', [ClassController::class, 'store'])->name('admin.classes.store');
    Route::get('admin/classes/{id}/show', [ClassController::class, 'show'])->name('admin.classes.show');
    Route::post('admin/classes/{classId}/addStudent', [ClassController::class, 'addStudentToClass'])
        ->name('admin.classes.addStudentToClass');
    Route::post('admin/classes/{classId}/removeStudent', [ClassController::class, 'removeStudentFromClass'])
        ->name('admin.classes.removeStudentFromClass');
    Route::get('classes/{id}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
    Route::put('classes/{id}', [ClassController::class, 'update'])->name('admin.classes.update');
    Route::delete('classes/{id}', [ClassController::class, 'destroy'])->name('admin.classes.destroy');

    // Subject Management
    Route::resource('subjects', SubjectController::class);

    // Exam Management
    Route::get('/exams/admin', [AdminExamController::class, 'index'])->name('admin.exams.index');
    Route::get('/admin/exams/class/{classId}', [AdminExamController::class, 'examsByClass'])
        ->name('admin.exams.byClass');
    Route::get('/admin/exams/exam/{examId}', [AdminExamController::class, 'studentsByExam'])
        ->name('admin.exams.studentsByExam');
});

// Guru-Specific Routes
Route::middleware(['auth', 'role:guru'])->group(function () {
    // Class Management
    Route::get('classes', [ClassController::class, 'index'])->name('guru.classes.index');

    // Task Management
    Route::resource('tasks', TaskController::class);
    Route::put('/tasks/{task}/students/{user}/update-score', [TaskController::class, 'updateScore'])
        ->name('tasks.updateScore');

    // Exam Management
    Route::get('/exams/teacher', [ExamController::class, 'index'])->name('guru.exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('guru.exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('guru.exams.store');
    Route::get('/exams/{id}/add-questions', [ExamController::class, 'addQuestions'])
        ->name('guru.exams.add_questions');
    Route::post('/exams/{id}/add-questions', [ExamController::class, 'storeQuestions'])
        ->name('guru.exams.store_questions');
    Route::get('/exams/teacher/{id}', [ExamController::class, 'show'])->name('guru.exams.show');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('guru.exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('guru.exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('guru.exams.destroy');
    Route::get('guru/ujian/{examId}/nilai', [ExamController::class, 'showStudentScores'])
        ->name('guru.exams.scores');
    Route::get('/guru/exams/{examId}/export', [ExamController::class, 'exportScores'])
        ->name('guru.exams.export');
    Route::get('/guru/exams/{exam}/scores/{attempt}/edit', [ExamController::class, 'editScore'])
        ->name('guru.exams.scores.edit');
    Route::put('/guru/exams/{exam}/scores/{attempt}', [ExamController::class, 'updateStudentScore'])
        ->name('guru.exams.scores.update');

    // Material Management
    Route::get('/guru/materials', [MaterialController::class, 'index'])->name('guru.materials.index');
    Route::get('/guru/materials/create', [MaterialController::class, 'create'])->name('guru.materials.create');
    Route::post('/guru/materials', [MaterialController::class, 'store'])->name('guru.materials.store');
    Route::get('/guru/materials/{material}', [MaterialController::class, 'show'])->name('guru.materials.show');
    Route::get('/guru/materials/{material}/edit', [MaterialController::class, 'edit'])->name('guru.materials.edit');
    Route::put('/guru/materials/{material}', [MaterialController::class, 'update'])->name('guru.materials.update');
    Route::delete('/guru/materials/{material}', [MaterialController::class, 'destroy'])->name('guru.materials.destroy');
});

// Siswa-Specific Routes
Route::middleware(['auth', 'role:siswa'])->group(function () {
    // Class Management
    Route::get('/classes/student', [ClassController::class, 'index'])->name('siswa.classes.index');
    Route::post('/classes/student/{id}/join', [ClassController::class, 'join'])->name('siswa.classes.join');

    // Task Management
    Route::get('/tasks-student', [TaskStudentController::class, 'index'])->name('student.tasks.index');
    Route::get('/student/tasks/{task}', [TaskStudentController::class, 'show'])->name('student.tasks.show');
    Route::post('/tasks/{task}/submit', [TaskStudentController::class, 'submit'])->name('student.tasks.submit');

    // Exam Management
    Route::get('/siswa/exams', [ExamAttemptController::class, 'index'])->name('siswa.exams.index');
    Route::get('/siswa/exams/start/{examId}', [ExamAttemptController::class, 'start'])->name('siswa.exams.start');
    Route::get('/siswa/exams/show/{examId}/{attemptId}', [ExamAttemptController::class, 'show'])
        ->name('siswa.exams.show');
    Route::post('/siswa/exams/answer/{attemptId}', [ExamAttemptController::class, 'saveAnswer'])
        ->name('siswa.exams.answer');
    Route::post('/siswa/exams/submit/{attemptId}', [ExamAttemptController::class, 'submit'])
        ->name('siswa.exams.submit');
    Route::get('/siswa/exams/{examId}/remedial', [ExamAttemptController::class, 'remedial'])
        ->name('siswa.exams.remedial');
    Route::get('/siswa/exams/preparation/{examId}', [ExamAttemptController::class, 'preparation'])
        ->name('siswa.exams.preparation');

    // Material Management
    Route::get('/siswa/materials', [StudentMaterialController::class, 'index'])->name('siswa.material.index');
    Route::get('/siswa/materials/{subject_id}', [StudentMaterialController::class, 'showMaterials'])
        ->name('siswa.material.list');
    Route::get('/siswa/materials/detail/{id}', [StudentMaterialController::class, 'showMaterialDetail'])
        ->name('siswa.material.detail');
});

// Dashboard Routes (Role-Based)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/guru/dashboard', [DashboardController::class, 'guruDashboard'])->name('guru.dashboard')->middleware('role:guru');
    Route::get('/siswa/dashboard', [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard')->middleware('role:siswa');
});