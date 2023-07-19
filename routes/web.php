<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware(['auth'])->group(function () {

        Route::group(['middleware' => ['role_registered']], function () {
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->middleware(['verified'])->name('dashboard');

            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            //Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        });

        Route::group(['middleware' => ['check_admin']], function () {
            Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
            Route::get('/admin/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/admin/store', [UserController::class, 'store'])->name('admin.users.store');
            Route::get('/admin/edit', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::get('/admin/update', [UserController::class, 'update'])->name('admin.users.update');
            Route::get('/admin/delete', [UserController::class, 'destroy'])->name('admin.users.delete');
            Route::get('/admin/students', [UserController::class, 'showstudentslist'])->name('admin.students');
            Route::get('/admin/teachers', [UserController::class, 'showTeacherlist'])->name('admin.teachers');
        });


        Route::get('role-registration', [RoleRegistrationController::class, 'create'])->name('role-registration.create');
        Route::post('role-registration', [RoleRegistrationController::class, 'store'])->name('role-registration.store');

    });


    require __DIR__ . '/auth.php';
});