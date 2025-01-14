<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorOpdIpdController;
use App\Http\Controllers\MacAddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitingFeeController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReferredDoctorController;
use App\Http\Controllers\medicines\GeneralMedicineController;
use App\Http\Controllers\medicines\OperationMedicineController;
use App\Http\Controllers\medicines\PostOperativeMedicineController;
use App\Http\Controllers\medicines\PreOperativeMedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\AccounDetail\OPDAccountDetailController;
use App\Http\Controllers\IpdDetailController;
use App\Http\Controllers\AccounDetail\IPDAccountDetailControoller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BalanceController;

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

Route::get('access-denied', function () {
    return view('access-denied');
})->name('access-denied');

Route::middleware(['mac_address_check', 'signout-check'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('signin.show');
    Route::post('/signin', [LoginController::class, 'signin'])->name('signin.submit');
});

Route::middleware(['mac_address_check', 'signin-check'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('signout', [DashboardController::class, 'signout'])->name('signout');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('change_password', [DashboardController::class, 'change_password'])->name('change_password');

    /* Doctor OPD/IPD */
    Route::middleware(['doctor_permission'])->prefix('doctor/opd-ipd')->name('doctor_opd_ipd.')->group(function () {
        Route::get('/', [DoctorOpdIpdController::class, 'list'])->name('list');
        Route::prefix('opd')->name('opd.')->group(function () {
            Route::get('view/{ap_id}', [DoctorOpdIpdController::class, 'opd_view'])->name('view');
            Route::get('prescription_show/{ap_id}', [DoctorOpdIpdController::class, 'opd_prescription_show'])->name('prescription.show');
        });
        Route::prefix('ipd')->name('ipd.')->group(function () {
            Route::get('view/{ipd_id}', [DoctorOpdIpdController::class, 'ipd_view'])->name('view');
        });
    });

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
        Route::get('payment/view/{tr_id}', [TraineeController::class, 'traineePaymentView'])->name('trainee.payment.view');
        Route::post('payment/store', [TraineeController::class, 'traineePaymentStore'])->name('trainee.payment.store');
        Route::get('payment/remove/{tpl_id}/{tr_id}', [TraineeController::class, 'traineePaymentRemove'])->name('trainee.payment.remove');
        Route::get('receipt/{tpl_id}', [TraineeController::class, 'paymentReceipt'])->name('trainee.payment.receipt');
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

        Route::prefix('post-operative-medicine')->group(function () {
            Route::get('create', [PostOperativeMedicineController::class, 'create'])->name('post-medicine.create')->middleware(['role_or_permission:post-operative-medicine-create']);
            Route::post('store', [PostOperativeMedicineController::class, 'store'])->name('post-medicine.store')->middleware(['role_or_permission:post-operative-medicine-create']);
            Route::get('list', [PostOperativeMedicineController::class, 'index'])->name('post-medicine.list')->middleware(['role_or_permission:post-operative-medicine-read']);
            Route::get('edit/{user_id}', [PostOperativeMedicineController::class, 'edit'])->name('post-medicine.edit')->middleware(['role_or_permission:post-operative-medicine-update']);
            Route::post('update/{user_id}', [PostOperativeMedicineController::class, 'update'])->name('post-medicine.update')->middleware(['role_or_permission:post-operative-medicine-update']);
            Route::get('status/{user_id}', [PostOperativeMedicineController::class, 'status'])->name('post-medicine.status')->middleware(['role_or_permission:post-operative-medicine-status']);
        });

        Route::prefix('pre-operative-medicine')->group(function () {
            Route::get('create', [PreOperativeMedicineController::class, 'create'])->name('pre-medicine.create')->middleware(['role_or_permission:pre-operative-medicine-create']);
            Route::post('store', [PreOperativeMedicineController::class, 'store'])->name('pre-medicine.store')->middleware(['role_or_permission:pre-operative-medicine-create']);
            Route::get('list', [PreOperativeMedicineController::class, 'index'])->name('pre-medicine.list')->middleware(['role_or_permission:pre-operative-medicine-read']);
            Route::get('edit/{user_id}', [PreOperativeMedicineController::class, 'edit'])->name('pre-medicine.edit')->middleware(['role_or_permission:pre-operative-medicine-update']);
            Route::post('update/{user_id}', [PreOperativeMedicineController::class, 'update'])->name('pre-medicine.update')->middleware(['role_or_permission:pre-operative-medicine-update']);
            Route::get('status/{user_id}', [PreOperativeMedicineController::class, 'status'])->name('pre-medicine.status')->middleware(['role_or_permission:pre-operative-medicine-status']);
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
        Route::get('print/{pa_id}', [PatientController::class, 'printPatient'])->name('patient.print');
    });
    /* Appointment Detail */
    Route::prefix('appointment')->group(function () {
        Route::get('create', [AppointmentController::class, 'create'])->name('appointment.create')->middleware(['role_or_permission:appointment-create']);
        Route::post('store', [AppointmentController::class, 'store'])->name('appointment.store')->middleware(['role_or_permission:appointment-create']);
        Route::get('list', [AppointmentController::class, 'index'])->name('appointment.list')->middleware(['role_or_permission:appointment-read']);
        Route::get('edit/{ap_id}', [AppointmentController::class, 'edit'])->name('appointment.edit')->middleware(['role_or_permission:appointment-edit']);
        Route::post('update/{ap_id}', [AppointmentController::class, 'update'])->name('appointment.update')->middleware(['role_or_permission:appointment-edit']);
        Route::get('doc/view/{ap_id}', [AppointmentController::class, 'appointmentDocView'])->name('appointment.doc.view');
        Route::post('doc/send', [AppointmentController::class, 'appointmentDocSend'])->name('appointment.doc.send');
        Route::get('doc/remove/{id?}', [AppointmentController::class, 'appointmentDocRemove'])->name('appointment.doc.remove');
        Route::get('doc/download/{id?}', [AppointmentController::class, 'appointmentDocDownload'])->name('appointment.doc.download');
        Route::get('status/{string_val}', [AppointmentController::class, 'status'])->name('appointment.status')->middleware(['role_or_permission:appointment-status']);
        Route::get('view/{ap_id}', [AppointmentController::class, 'view'])->name('appointment.view')->middleware(['role_or_permission:appointment-full-view|follow-up-opd-notes']);
        Route::get('prescribe/{ap_id}', [AppointmentController::class, 'prescribe'])->name('appointment.prescribe')->middleware(['role_or_permission:appointment-prescription']);
        Route::post('prescribe/store/{ap_id}', [AppointmentController::class, 'prescribe_store'])->name('appointment.prescribe.store')->middleware(['role_or_permission:appointment-prescription']);
        Route::get('prescribe/medicine/store', [AppointmentController::class, 'appointmentMedicineStore'])->name('appointment.medicine.store');
        Route::get('prescribe/medicine/remove/{am_id}', [AppointmentController::class, 'appointmentMedicineRemove'])->name('appointment.medicine.remove');
        Route::get('prescribe/medicine/serch/{gm_name}', [AppointmentController::class, 'searchGenerlMedicineList'])->name('appointment.prescribe-medicine.search.list');
        Route::get('patient_all_appointment/{pa_id}', [AppointmentController::class, 'patientAllAppointment'])->name('appointment.all_poointment');
        Route::get('export', [AppointmentController::class, 'export'])->name('appointment.export');
        Route::get('bill_print/{ap_id}', [AppointmentController::class, 'bill_print'])->name('appointment.bill_print')->middleware(['role_or_permission:appointment-bill-print']);
        Route::get('prescription_bill_print/{ap_id}', [AppointmentController::class, 'prescription_bill_print'])->name('appointment.prescription_bill_print');
        Route::get('note_update/{ap_id}', [AppointmentController::class, 'note_update'])->name('appointment.note.update');
    });
    /* Follow Up Info */
    Route::prefix('follow-up')->name('follow-up.')->group(function () {
        Route::prefix('opd')->group(function () {
            Route::get('list', [FollowUpController::class, 'index'])->name('list')->middleware(['role_or_permission:follow-up-opd-read']);
            Route::get('export', [FollowUpController::class, 'export'])->name('export');
        });
        Route::prefix('ipd')->group(function () {
            Route::get('list', [FollowUpController::class, 'ipd_index'])->name('ipd.list')->middleware(['role_or_permission:follow-up-ipd-read']);
            Route::get('export', [FollowUpController::class, 'ipd_export'])->name('ipd.export');
        });
    });
    /* Appointment Account Detail */
    Route::prefix('opd-account-detail')->name('opd-account-detail.')->group(function () {
        Route::get('/', [OPDAccountDetailController::class, 'index'])->name('list')->middleware(['role_or_permission:account-detail-opd-read']);
        Route::get('additional_charge/list/{ap_id}/{queryData?}', [OPDAccountDetailController::class, 'additionalChargeList'])->name('additional-charge.list')->middleware(['role_or_permission:appointment-additional-charge|account-detail-opd-additional-charge']);
        Route::get('additional-charge/store', [OPDAccountDetailController::class, 'additionalChargeStore'])->name('additional-charge.store');
        Route::get('additional-charge/remove/{apac_id}/{ap_id}/{queryData}', [OPDAccountDetailController::class, 'additionalChargeRemove'])->name('additional-charge.remove');
    });
    /* IPD Detail */
    Route::prefix('ipd')->group(function () {
        Route::get('list', [IpdDetailController::class, 'index'])->name('ipd.list')->middleware(['role_or_permission:ipd-read']);
        Route::get('create', [IpdDetailController::class, 'create'])->name('ipd.create')->middleware(['role_or_permission:ipd-create']);
        Route::post('store', [IpdDetailController::class, 'store'])->name('ipd.store')->middleware(['role_or_permission:ipd-create']);
        Route::get('edit/{ipd_id}', [IpdDetailController::class, 'edit'])->name('ipd.edit')->middleware(['role_or_permission:ipd-edit']);
        Route::post('update/{ipd_id}', [IpdDetailController::class, 'update'])->name('ipd.update')->middleware(['role_or_permission:ipd-edit']);
        Route::get('doc/view/{ipd_id}', [IpdDetailController::class, 'ipdDocView'])->name('ipd.doc.view');
        Route::post('doc/send', [IpdDetailController::class, 'ipdDocSend'])->name('ipd.doc.send');
        Route::get('doc/remove/{id?}', [IpdDetailController::class, 'ipdDocRemove'])->name('ipd.doc.remove');
        Route::get('doc/download/{id?}', [IpdDetailController::class, 'ipdDocDownload'])->name('ipd.doc.download');
        Route::get('view/{ipd_id}', [IpdDetailController::class, 'view'])->name('ipd.view')->middleware(['role_or_permission:ipd-status|ipd-full-view|ipd-bill-amount']);
        Route::get('status/{string_val}', [IpdDetailController::class, 'status'])->name('ipd.status')->middleware(['role_or_permission:ipd-status']);
        Route::get('bill_amount_update/{ipd_id}', [IpdDetailController::class, 'BillAmountUpdate'])->name('ipd.bill_amount.update')->middleware(['role_or_permission:ipd-bill-amount']);
        Route::get('operative_note/{ipd_id}', [IpdDetailController::class, 'IPDOperativeNote'])->name('ipd.operative_note.view')->middleware(['role_or_permission:ipd-operative-note']);
        Route::get('operative_note_update/{ipd_id}', [IpdDetailController::class, 'IPDOperativeNoteUpdate'])->name('ipd.operative_note.update')->middleware(['role_or_permission:ipd-operative-notes']);
        Route::get('operative_note_print/{ipd_id}', [IpdDetailController::class, 'IPDOperativeNotePrint'])->name('ipd.operative_note.print');
        Route::get('prescription_view/{ipd_id}', [IpdDetailController::class, 'PrescriptionView'])->name('ipd.prescription.view')->middleware(['role_or_permission:ipd-prescribe']);
        Route::get('operation_medicine_print/{ipd_id}', [IpdDetailController::class, 'IPDOperationMedicinePrint'])->name('ipd.operation_medicine.print');
        Route::get('ipd_bill_print/{ipd_id}', [IpdDetailController::class, 'IPDBillPrint'])->name('ipd.bill.print')->middleware(['role_or_permission:ipd-detail-print']);
        Route::get('prescription_update/{ipd_id}', [IpdDetailController::class, 'PrescriptionUpdate'])->name('ipd.prescription.update');
        Route::get('opd_history/{pa_id}', [IpdDetailController::class, 'OpdHistory'])->name('ipd.opd_history')->middleware(['role_or_permission:follow-up-ipd-opd-history|ipd-opd-history']);
        Route::get('ipd_history/{pa_id}', [IpdDetailController::class, 'IpdHistory'])->name('ipd.ipd_history')->middleware(['role_or_permission:follow-up-ipd-ipd-history|ipd-ipd-history']);
        Route::get('export', [IpdDetailController::class, 'export'])->name('ipd.export');
        Route::get('note_update/{ipd_id}', [IpdDetailController::class, 'note_update'])->name('ipd.note.update');
        Route::get('pre_operative_medicine/list/{ipd_id}', [IpdDetailController::class, 'PreOperativeMedicinetList'])->name('ipd.pre_operative_medicine.list');
        Route::post('pre_operative_medicine/create', [IpdDetailController::class, 'PreOperativeMedicinetCreate'])->name('ipd.pre_operative_medicine.add');
        Route::get('pre_operative_medicine/remove/{ipom_id}', [IpdDetailController::class, 'PreOperativeMedicinetRemove'])->name('ipd.pre_operative_medicine.remove');
        Route::get('indoor_sheet/list/{ipd_id}', [IpdDetailController::class, 'IndoorSheetList'])->name('ipd.indoor_sheet.list');
        Route::post('indoor_sheet/findings/create', [IpdDetailController::class, 'IndoorSheetFindingsCreate'])->name('ipd.indoor_sheet.findings.add');
        Route::get('indoor_sheet/findings/remove/{is_id}', [IpdDetailController::class, 'IndoorSheetFindingsRemove'])->name('ipd.indoor_sheet.findings.remove');
        Route::get('indoor_sheet/medicine/list/{is_id}', [IpdDetailController::class, 'IndoorSheetMedicineList'])->name('ipd.indoor_sheet.medicine.list');
        Route::post('indoor_sheet/medicine/create', [IpdDetailController::class, 'IndoorSheetMedicineCreate'])->name('ipd.indoor_sheet.medicine.add');
        Route::get('indoor_sheet/medcine/remove/{ism_id}', [IpdDetailController::class, 'IndoorSheetMedicineRemove'])->name('ipd.indoor_sheet.medicine.remove');
        Route::get('examination_sheet/list/{ipd_id}', [IpdDetailController::class, 'ExaminationSheetList'])->name('ipd.examination_sheet.list');
        Route::get('examination_sheet/medicine/list/{is_id}', [IpdDetailController::class, 'ExaminationSheetMedicineList'])->name('ipd.examination_sheet.medicine.list');
        Route::post('examination_sheet/medicine/add', [IpdDetailController::class, 'ExaminationSheetMedicineAdd'])->name('ipd.examination_sheet.medicine.add');
        Route::get('examination_sheet/medicine/remove/{isme_id}', [IpdDetailController::class, 'ExaminationSheetMedicineRemove'])->name('ipd.examination_sheet.medicine.remove');
        Route::get('examination_sheet/medicine/edit/{isme_id}', [IpdDetailController::class, 'ExaminationSheetMedicineEdit'])->name('ipd.examination_sheet.medicine.edit');
        Route::post('examination_sheet/medicine/update', [IpdDetailController::class, 'ExaminationSheetMedicineUpdate'])->name('ipd.examination_sheet.medicine.update');
    });
    /* IPD Account Detail */
    Route::prefix('ipd-account-detail')->name('ipd-acount-detail.')->group(function () {
        Route::get('list', [IPDAccountDetailControoller::class, 'index'])->name('list')->middleware(['role_or_permission:account-detail-ipd-read']);
        Route::get('bill-detail/{ipd_id}', [IPDAccountDetailControoller::class, 'bill_detail'])->name('bill-detail')->middleware(['role_or_permission:account-detail-ipd-bill-amount']);
        Route::post('bill-detail/discount-update', [IPDAccountDetailControoller::class, 'discount_update'])->name('bill-discount-update')->middleware(['role_or_permission:account-detail-ipd-bill-amount']);
        Route::get('charge/add/{ipd_id}', [IPDAccountDetailControoller::class, 'charge_add'])->name('charge.add');
        Route::get('charge/remove/{ic_id}', [IPDAccountDetailControoller::class, 'charge_remove'])->name('charge.remove');
        Route::get('charge/single/{ic_id}', [IPDAccountDetailControoller::class, 'charge_single'])->name('charge.single');
        Route::get('payment/add/{ipd_id}', [IPDAccountDetailControoller::class, 'payment_add'])->name('payment.add');
        Route::get('payment/remove/{ipl_id}', [IPDAccountDetailControoller::class, 'payment_remove'])->name('payment.remove');
        Route::get('payment/single/{ipl_id}', [IPDAccountDetailControoller::class, 'payment_single'])->name('payment.single');
        Route::get('print_receipt/{ipl_id}/{ipd_id}', [IPDAccountDetailControoller::class, 'print_receipt'])->name('payment.receipt.print');
        Route::get('print_bill/{ipd_id}', [IPDAccountDetailControoller::class, 'print_bill'])->name('payment.bill.print')->middleware(['role_or_permission:account-detail-ipd-print-bill']);
    });

    /* Balance */
    Route::prefix('balance')->name('balance')->group(function () {
        Route::get('opd', [BalanceController::class, 'OPDBalance'])->name('.opd')->middleware(['role_or_permission:balance-read']);;
        Route::get('ipd', [BalanceController::class, 'IPDBalance'])->name('.ipd')->middleware(['role_or_permission:balance-read']);;
    });

    Route::prefix('notification')->name('notification.')->group(function () {
        Route::get('open', [NotificationController::class, 'read_notification'])->name('read');
    });
});
