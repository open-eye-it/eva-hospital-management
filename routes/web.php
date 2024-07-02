<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MacAddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitingFeeController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReferredDoctorController;
use App\Http\Controllers\medicines\GeneralMedicineController;
use App\Http\Controllers\medicines\OperationMedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AccounDetail\OPDAccountDetailController;

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

    /* Mac Address */
    Route::prefix('mac_address')->group(function () {
        Route::get('create', [MacAddressController::class, 'create'])->name('mac_address.create')->middleware(['role_or_permission:mac-address-create']);
        Route::post('store', [MacAddressController::class, 'store'])->name('mac_address.store')->middleware(['role_or_permission:mac-address-create']);
        Route::get('list', [MacAddressController::class, 'index'])->name('mac_address.list')->middleware(['role_or_permission:mac-address-read']);
        Route::get('edit/{ma_id}', [MacAddressController::class, 'edit'])->name('mac_address.edit')->middleware(['role_or_permission:mac-address-update']);
        Route::post('update/{ma_id}', [MacAddressController::class, 'update'])->name('mac_address.update')->middleware(['role_or_permission:mac-address-update']);
        Route::get('status/{ma_id}', [MacAddressController::class, 'status'])->name('mac_address.status')->middleware(['role_or_permission:mac-address-status']);
        Route::get('remove/{ma_id}', [MacAddressController::class, 'remove'])->name('mac_address.remove')->middleware(['role_or_permission:mac-address-remove']);
    });
    /* User Category And Roles */
    Route::prefix('category')->group(function () {
        Route::get('create', [CategoryController::class, 'create'])->name('category.create')->middleware(['role_or_permission:category-create']);
        Route::post('store', [CategoryController::class, 'store'])->name('category.store')->middleware(['role_or_permission:category-create']);
        Route::get('list', [CategoryController::class, 'index'])->name('category.list')->middleware(['role_or_permission:category-read']);
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware(['role_or_permission:category-update']);
        Route::post('update/{ma_id}', [CategoryController::class, 'update'])->name('category.update')->middleware(['role_or_permission:category-update']);
        Route::get('status/{ma_id}', [CategoryController::class, 'status'])->name('category.status')->middleware(['role_or_permission:category-status']);
    });
    /* System Users */
    Route::prefix('user')->group(function () {
        Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(['role_or_permission:user-create']);
        Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(['role_or_permission:user-create']);
        Route::get('list', [UserController::class, 'index'])->name('user.list')->middleware(['role_or_permission:user-read']);
        Route::get('edit/{user_id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['role_or_permission:user-update']);
        Route::post('update/{user_id}', [UserController::class, 'update'])->name('user.update')->middleware(['role_or_permission:user-update']);
        Route::get('status/{user_id}', [UserController::class, 'status'])->name('user.status')->middleware(['role_or_permission:user-status']);
        Route::get('view/{user_id}', [UserController::class, 'viewUser'])->name('user.view')->middleware(['role_or_permission:user-read']);
    });
    /* Visiting Fee */
    Route::prefix('visiting_fee')->group(function () {
        Route::get('/', [VisitingFeeController::class, 'index'])->name('visiting_fee.list')->middleware(['role_or_permission:visiting-fee-read']);
        Route::get('edit/{vf_id}', [VisitingFeeController::class, 'edit'])->name('visiting_fee.edit')->middleware(['role_or_permission:visiting-fee-update']);
        Route::post('update/{vf_id}', [VisitingFeeController::class, 'update'])->name('visiting_fee.update')->middleware(['role_or_permission:visiting-fee-update']);
    });
    /* Trainee */
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
    /* Hospital Rooms with building, floor, ward, bed */
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
    /* Referred Doctor for appointment */
    Route::prefix('referred-doctor')->group(function () {
        Route::get('create', [ReferredDoctorController::class, 'create'])->name('referred-doctor.create')->middleware(['role_or_permission:referred-doctor-create']);
        Route::post('store', [ReferredDoctorController::class, 'store'])->name('referred-doctor.store')->middleware(['role_or_permission:referred-doctor-create']);
        Route::get('list', [ReferredDoctorController::class, 'index'])->name('referred-doctor.list')->middleware(['role_or_permission:referred-doctor-read']);
        Route::get('edit/{user_id}', [ReferredDoctorController::class, 'edit'])->name('referred-doctor.edit')->middleware(['role_or_permission:referred-doctor-update']);
        Route::post('update/{user_id}', [ReferredDoctorController::class, 'update'])->name('referred-doctor.update')->middleware(['role_or_permission:referred-doctor-update']);
        Route::get('search_list/{rd_name}', [ReferredDoctorController::class, 'searchList'])->name('referred-doctor.search.list');
    });
    /* General And Operation Medicine for patient */
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
    /* Patient Detail */
    Route::prefix('patient')->group(function () {
        Route::get('create', [PatientController::class, 'create'])->name('patient.create')->middleware(['role_or_permission:patient-create']);
        Route::post('store', [PatientController::class, 'store'])->name('patient.store')->middleware(['role_or_permission:patient-create']);
        Route::get('list', [PatientController::class, 'index'])->name('patient.list')->middleware(['role_or_permission:patient-read']);
        Route::get('edit/{pa_id}', [PatientController::class, 'edit'])->name('patient.edit')->middleware(['role_or_permission:patient-update']);
        Route::post('update/{pa_id}', [PatientController::class, 'update'])->name('patient.update')->middleware(['role_or_permission:patient-update']);
        Route::get('status/{pa_id}', [PatientController::class, 'status'])->name('patient.status')->middleware(['role_or_permission:patient-status']);
        Route::get('view/{pa_id}', [PatientController::class, 'view'])->name('patient.view')->middleware(['role_or_permission:patient-read']);
    });
    /* Appointment Detail */
    Route::prefix('appointment')->group(function () {
        Route::get('create', [AppointmentController::class, 'create'])->name('appointment.create');
        Route::post('store', [AppointmentController::class, 'store'])->name('appointment.store');
        Route::get('list', [AppointmentController::class, 'index'])->name('appointment.list');
        Route::get('edit/{ap_id}', [AppointmentController::class, 'edit'])->name('appointment.edit');
        Route::post('update/{ap_id}', [AppointmentController::class, 'update'])->name('appointment.update');
        Route::get('status/{string_val}', [AppointmentController::class, 'status'])->name('appointment.status');
        Route::get('view/{ap_id}', [AppointmentController::class, 'view'])->name('appointment.view');
        Route::get('prescribe/{ap_id}', [AppointmentController::class, 'prescribe'])->name('appointment.prescribe');
        Route::post('prescribe/store/{ap_id}', [AppointmentController::class, 'prescribe_store'])->name('appointment.prescribe.store');
        Route::get('prescribe/medicine/store', [AppointmentController::class, 'appointmentMedicineStore'])->name('appointment.medicine.store');
        Route::get('prescribe/medicine/remove/{am_id}', [AppointmentController::class, 'appointmentMedicineRemove'])->name('appointment.medicine.remove');
        Route::get('patient_all_appointment/{pa_id}', [AppointmentController::class, 'patientAllAppointment'])->name('appointment.all_poointment');
    });

    /* Appointment Account Detail */
    Route::prefix('opd-account-detail')->group(function () {
        Route::get('list', [OPDAccountDetailController::class, 'index'])->name('opd-account-detail.list');
        Route::get('additional_charge/list/{ap_id}', [OPDAccountDetailController::class, 'additionalChargeList'])->name('opd-account-detail.additional-charge.list');
        Route::get('additional-charge/store', [OPDAccountDetailController::class, 'additionalChargeStore'])->name('opd-account-detail.additional-charge.store');
        Route::get('additional-charge/remove/{apac_id}', [OPDAccountDetailController::class, 'additionalChargeRemove'])->name('opd-account-detail.additional-charge.remove');
    });
});
