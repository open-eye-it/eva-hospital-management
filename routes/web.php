<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitingFeeController;
use App\Http\Controllers\TraineeController;

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

Route::middleware('signout-check')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('signin.show');
    Route::post('/signin', [LoginController::class, 'signin'])->name('signin.submit');
});

Route::middleware('signin-check')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/signout', [DashboardController::class, 'signout'])->name('signout');

    Route::prefix('category')->group(function () {
        Route::get('create', [CategoryController::class, 'create'])->name('category.create')->middleware(['role_or_permission:category-create']);
        Route::post('store', [CategoryController::class, 'store'])->name('category.store')->middleware(['role_or_permission:category-create']);
        Route::get('list', [CategoryController::class, 'index'])->name('category.list')->middleware(['role_or_permission:category-read']);
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware(['role_or_permission:category-update']);
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware(['role_or_permission:category-update']);
        Route::get('status/{id}', [CategoryController::class, 'status'])->name('category.status')->middleware(['role_or_permission:category-status']);
    });

    Route::prefix('user')->group(function () {
        Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(['role_or_permission:user-create']);
        Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(['role_or_permission:user-create']);
        Route::get('list', [UserController::class, 'index'])->name('user.list')->middleware(['role_or_permission:user-read']);
        Route::get('edit/{user_id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['role_or_permission:user-update']);
        Route::post('update/{user_id}', [UserController::class, 'update'])->name('user.update')->middleware(['role_or_permission:user-update']);
        Route::get('status/{user_id}', [UserController::class, 'status'])->name('user.status')->middleware(['role_or_permission:user-status']);
        Route::get('view/{user_id}', [UserController::class, 'viewUser'])->name('user.view')->middleware(['role_or_permission:user-read']);
    });

    Route::prefix('visiting_fee')->group(function () {
        Route::get('/', [VisitingFeeController::class, 'index'])->name('visiting_fee.list')->middleware(['role_or_permission:visiting-fee-read']);
        Route::get('edit/{vf_id}', [VisitingFeeController::class, 'edit'])->name('visiting_fee.edit')->middleware(['role_or_permission:visiting-fee-update']);
        Route::post('update/{vf_id}', [VisitingFeeController::class, 'update'])->name('visiting_fee.update')->middleware(['role_or_permission:visiting-fee-update']);
    });

    Route::prefix('trainee')->group(function () {
        Route::get('/', [TraineeController::class, 'index'])->name('trainee.list')->middleware(['role_or_permission:trainee-read']);
        Route::get('create', [TraineeController::class, 'create'])->name('trainee.create')->middleware(['role_or_permission:trainee-create']);
        Route::post('store/{tr_real_id}', [TraineeController::class, 'store'])->name('trainee.store')->middleware(['role_or_permission:trainee-create']);
        Route::get('edit/{tr_id}', [TraineeController::class, 'edit'])->name('trainee.edit')->middleware(['role_or_permission:trainee-update']);
        Route::post('update/{tr_id}', [TraineeController::class, 'update'])->name('trainee.update')->middleware(['role_or_permission:trainee-update']);
        Route::get('view/{tr_id}', [TraineeController::class, 'viewTrainee'])->name('trainee.view')->middleware(['role_or_permission:trainee-read']);
        Route::get('status/{tr_id}', [TraineeController::class, 'status'])->name('trainee.status')->middleware(['role_or_permission:trainee-status']);
    });
});
