<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// })->name('home');
Route::get('/', [CourseController::class,'populer'])->name('home');

Route::get('/courses', [CourseController::class, 'kelas'])->name('courses.index');
Route::get('/courses/search', [CourseController::class, 'search'])->name('course.search');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registrasi', [RegisterController::class, 'index'])->name('registrasi')->middleware('guest');
Route::post('/registrasi', [RegisterController::class, 'store'])->name('registrasi')->middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard/index');
})->name('dashboard')->middleware('auth', 'checkSiswa');

Route::middleware('isAdmin')->group(function () {
    Route::get('/dashboard/user', [UserController::class, 'index'])->name('user');
    Route::get('dashboard/user/{user}/edit', [RegisterController::class, 'edit'])->name('edit');
    Route::put('dashboard/user/{user}', [RegisterController::class, 'update'])->name('update');
    Route::delete('dashboard/user/{user}', [RegisterController::class, 'destroy'])->name('destroy');
    Route::get('/dashboard/user/create', [UserController::class, 'create'])->name('create');
    Route::post('/dashboard/user', [UserController::class, 'store'])->name('store');
});

Route::middleware('course.access')->group(function () {
    Route::get('dashboard/course', [CourseController::class, 'index'])->name('course.index');
    Route::get('dashboard/course/create', [CourseController::class, 'create'])->name('createCourse');
    Route::post('dashboard/course', [CourseController::class, 'store'])->name('storeCourse');
    Route::put('dashboard/course/{course}', [CourseController::class, 'update'])->name('updateCourse');
    Route::get('dashboard/course/{course}/edit', [CourseController::class, 'edit'])->name('editCourse');
    Route::delete('dashboard/course/{course}', [CourseController::class, 'destroy'])->name('destroyCourse');
});

Route::get('/content/{courseName}', [ContentController::class, 'index'])->name('content.index');
Route::get('/content/{courseName}/{judulMateri?}', [ContentController::class, 'showContent'])->name('show.content');
Route::get('/content/{courseName}/{judulMateri}', [ContentController::class, 'tampil'])
    ->name('tampil.content');

Route::middleware('course.access')->group(function () {
    Route::get('dashboard/content', [ContentController::class, 'show'])->name('content.show');
    Route::get('dashboard/content/create', [ContentController::class, 'create'])->name('createContent');
    Route::post('dashboard/content', [ContentController::class, 'store'])->name('storeContent');
    Route::put('dashboard/content/{id}', [ContentController::class, 'update'])->name('updateContent');
    Route::get('dashboard/content/{id}/edit', [ContentController::class, 'edit'])->name('editContent');
    Route::delete('dashboard/content/{id}', [ContentController::class, 'destroy'])->name('destroyContent');
});

Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
