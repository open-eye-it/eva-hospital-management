<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitingFeeController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\medicines\GeneralMedicineController;
use App\Http\Controllers\medicines\OperationMedicineController;
use App\Http\Controllers\ReferredDoctorController;

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
        Route::get('list', [TraineeController::class, 'index'])->name('trainee.list')->middleware(['role_or_permission:trainee-read']);
        Route::get('create', [TraineeController::class, 'create'])->name('trainee.create')->middleware(['role_or_permission:trainee-create']);
        Route::post('store/{tr_real_id}', [TraineeController::class, 'store'])->name('trainee.store')->middleware(['role_or_permission:trainee-create']);
        Route::get('edit/{tr_id}', [TraineeController::class, 'edit'])->name('trainee.edit')->middleware(['role_or_permission:trainee-update']);
        Route::post('update/{tr_id}', [TraineeController::class, 'update'])->name('trainee.update')->middleware(['role_or_permission:trainee-update']);
        Route::get('view/{tr_id}', [TraineeController::class, 'viewTrainee'])->name('trainee.view')->middleware(['role_or_permission:trainee-read']);
        Route::get('status/{tr_id}', [TraineeController::class, 'status'])->name('trainee.status')->middleware(['role_or_permission:trainee-status']);
        Route::get('download/{file}', [TraineeController::class, 'downloadFile'])->name('trainee.file.download')->middleware(['role_or_permission:trainee-read']);
        Route::get('certificate/{tr_id}', [TraineeController::class, 'certificatePDF'])->name('trainee.certificate.pdf')->middleware(['role_or_permission:trainee-certificate']);
    });

    Route::prefix('room')->group(function () {
        Route::get('create', [RoomController::class, 'create'])->name('room.create');
        Route::post('store', [RoomController::class, 'store'])->name('room.store');
        Route::get('list', [RoomController::class, 'index'])->name('room.list');
        Route::get('edit/{rm_id}', [RoomController::class, 'edit'])->name('room.edit');
        Route::post('update/{rm_id}', [RoomController::class, 'update'])->name('room.update');
        Route::get('status/{rm_id}', [RoomController::class, 'status'])->name('room.status');
        Route::get('floor_filter/{rm_building}', [RoomController::class, 'floorFilter'])->name('room.floor.filter');
        Route::get('ward_filter/{rm_building}/{rm_floor}', [RoomController::class, 'wardFilter'])->name('room.ward.filter');
        Route::get('room_filter/{rm_building}/{rm_floor}/{rm_ward}', [RoomController::class, 'roomFilter'])->name('room.room.filter');
    });

    Route::prefix('medicine')->group(function () {
        Route::prefix('general-medicine')->group(function () {
            Route::get('create', [GeneralMedicineController::class, 'create'])->name('general-medicine.create')->middleware(['role_or_permission:general-medicine-create']);
            Route::post('store', [GeneralMedicineController::class, 'store'])->name('general-medicine.store')->middleware(['role_or_permission:general-medicine-create']);
            Route::get('list', [GeneralMedicineController::class, 'index'])->name('general-medicine.list')->middleware(['role_or_permission:general-medicine-read']);
            Route::get('edit/{user_id}', [GeneralMedicineController::class, 'edit'])->name('general-medicine.edit')->middleware(['role_or_permission:general-medicine-update']);
            Route::post('update/{user_id}', [GeneralMedicineController::class, 'update'])->name('general-medicine.update')->middleware(['role_or_permission:general-medicine-update']);
            Route::get('status/{user_id}', [GeneralMedicineController::class, 'status'])->name('general-medicine.status')->middleware(['role_or_permission:general-medicine-status']);
        });

        Route::prefix('operation-medicine')->group(function () {
            Route::get('create', [OperationMedicineController::class, 'create'])->name('operation-medicine.create')->middleware(['role_or_permission:operation-medicine-create']);
            Route::post('store', [OperationMedicineController::class, 'store'])->name('operation-medicine.store')->middleware(['role_or_permission:operation-medicine-create']);
            Route::get('list', [OperationMedicineController::class, 'index'])->name('operation-medicine.list')->middleware(['role_or_permission:operation-medicine-read']);
            Route::get('edit/{user_id}', [OperationMedicineController::class, 'edit'])->name('operation-medicine.edit')->middleware(['role_or_permission:operation-medicine-update']);
            Route::post('update/{user_id}', [OperationMedicineController::class, 'update'])->name('operation-medicine.update')->middleware(['role_or_permission:operation-medicine-update']);
            Route::get('status/{user_id}', [OperationMedicineController::class, 'status'])->name('operation-medicine.status')->middleware(['role_or_permission:operation-medicine-status']);
        });
    });

    Route::prefix('referred-doctor')->group(function () {
        Route::get('create', [ReferredDoctorController::class, 'create'])->name('referred-doctor.create')->middleware(['role_or_permission:referred-doctor-create']);
        Route::post('store', [ReferredDoctorController::class, 'store'])->name('referred-doctor.store')->middleware(['role_or_permission:referred-doctor-create']);
        Route::get('list', [ReferredDoctorController::class, 'index'])->name('referred-doctor.list')->middleware(['role_or_permission:referred-doctor-read']);
        Route::get('edit/{user_id}', [ReferredDoctorController::class, 'edit'])->name('referred-doctor.edit')->middleware(['role_or_permission:referred-doctor-update']);
        Route::post('update/{user_id}', [ReferredDoctorController::class, 'update'])->name('referred-doctor.update')->middleware(['role_or_permission:referred-doctor-update']);
    });
});
