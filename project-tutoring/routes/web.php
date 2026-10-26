<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseCatalogController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', HomeController::class)->name('home');
Route::get('/courses', [CourseCatalogController::class, 'index'])->name('courses.index');

// URL course & materi memakai slug, misalnya /courses/matematika-dasar/bab-1-bilangan-bulat.
// scopeBindings() memastikan materi yang dibuka memang milik course di URL tersebut.
Route::get('/courses/{course}', [LearningController::class, 'course'])->name('courses.show');
Route::get('/courses/{course}/{content}', [LearningController::class, 'content'])->name('courses.contents.show')->scopeBindings();

// Tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    // Maksimal 5 percobaan login per menit untuk mencegah tebak-tebakan password (brute force)
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/registrasi', [RegisterController::class, 'create'])->name('register');
    Route::post('/registrasi', [RegisterController::class, 'store']);
});

// User yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Dashboard untuk Admin & Guru. Dashboard memakai ID (bukan slug) karena slug materi hanya unik per course.
    Route::middleware('role:Admin,Guru')->group(function () {
        Route::view('/dashboard', 'dashboard.index')->name('dashboard');

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::resource('courses', CourseController::class)->except('show')->scoped(['course' => 'id']);
            Route::resource('contents', ContentController::class)->except('show')->scoped(['content' => 'id']);
            Route::resource('users', UserController::class)->except('show')->middleware('role:Admin');
        });
    });
});
