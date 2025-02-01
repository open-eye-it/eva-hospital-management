<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Exports\AppointmentExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\VisitingFee;
use App\Models\GeneralMedicine;
use App\Models\AppointmentMedicine;
use App\Models\Notification;
use App\Models\AppointmentDocument;

class AppointmentController extends MainController
{
    public $appointment, $patient, $ap_doc, $user, $visiting_fee, $general_medicine, $appointment_medicine, $notification;
    public function __construct()
    {
        parent::__construct();
        $this->appointment          = new Appointment;
        $this->patient              = new Patient;
        $this->ap_doc               = new AppointmentDocument;
        $this->user                 = new User;
        $this->visiting_fee         = new VisitingFee;
        $this->general_medicine     = new GeneralMedicine;
        $this->appointment_medicine = new AppointmentMedicine;
        $this->notification         = new notification;
    }

    /* appointment list show */
    public function index(Request $request)
    {
        $userLogin = Auth::user();
        $userRole = $userLogin->roles->pluck('id')[0];
        $input = $request->all();
        $patientList = $this->patient->getList([], false);
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();

        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['patient']  = isset($input['patient']) ? $input['patient'] : '';
        $searchData['patient_id_phone_number'] = isset($input['patient_id_phone_number']) ? $input['patient_id_phone_number'] : '';
        // $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : '';
        $searchData['doctor']  = isset($input['doctor']) ? $input['doctor'] : (($userRole == 2) ? $userLogin->user_id : '');
        $searchData['case_type']  = isset($input['case_type']) ? $input['case_type'] : '';
        $searchData['ap_status']  = isset($input['ap_status']) ? $input['ap_status'] : 'pending';
        $list = $this->appointment->getList($searchData);
        return view('appointment.list', compact('list', 'searchData', 'patientList', 'doctors', 'visitingFees'));
    }

    /* appointment create */
    public function create(Request $request)
    {
        $input = $request->all();
        $pa_id = isset($input['patient']) ? $input['patient'] : '';
        $pa_id = base64_decode($pa_id);

        $patientList = $this->patient->patientActiveList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();
        return view('appointment.create', compact('patientList', 'doctors', 'visitingFees', 'pa_id'));
    }

    /* appointment store */
    public function store(Request $request)
    {
        $input = $request->all();
        $login_user = Auth::user();
        $login_user_id = $login_user->user_id;

        $input['ap_id'] = $this->getUniqueID();
        $input['ap_added_by'] = $login_user_id;
        $input['ap_updated_by'] = $login_user_id;

        $case_type_arr = explode('-', $input['ap_case_type']);
        $input['ap_case_type'] = $case_type_arr[0];
        if ($input['ap_is_workshop'] == 'no') {
            $input['ap_charge'] = $case_type_arr[1];
        }

        $insert = $this->appointment->insertData($input);
        if (isset($insert->ap_id)) {
            $notificationData = [
                'no_id' => $this->getUniqueID(),
                'ap_id' => $insert->ap_id,
                'no_type' => 1,
                'no_subject' => notificationSubjectList('opd_add'),
                'no_message' => notificationMessageList('opd_add'),
                'no_icon'    => notificationIconList('opd_add'),
                'no_action'  => 'opd_add_doctor',
                'no_created_for' => $input['ap_doctor'],
                'no_created_by' => $login_user->user_id
            ];
            $this->notification->insertData($notificationData);

            return $this->getSuccessResult([], 'Appointment added', true);
        } else {
            return $this->getErrorMessage('Appointment not added, something is wrong.');
        }
    }

    /* appointment edit */
    public function edit($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        if (!empty($data)) {
            $patientList = $this->patient->getList();
            $doctorList = User::select('user_id', 'person_name')->role('doctor')->orderBy('id', 'asc')->get()->toArray();
            $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->orderBy('id', 'asc')->get()->toArray();
            $doctors = array_merge($doctorList, $assDoctorList);
            $visitingFees = $this->visiting_fee->getList();
            return view('appointment.edit', compact('data', 'patientList', 'doctors', 'visitingFees'));
        } else {
            return redirect()->route('appointment.list');
        }
    }

    /* appointment update */
    public function update(Request $request, $ap_id)
    {
        $input = $request->all();
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        if (!empty($data)) {
            $login_user_id = Auth::user()->user_id;
            $input['ap_updated_by'] = $login_user_id;

            $case_type_arr = explode('-', $input['ap_case_type']);
            $input['ap_case_type'] = $case_type_arr[0];
            if ($input['ap_is_workshop'] == 'no') {
                $input['ap_charge'] = $case_type_arr[1];
            }
            $update = $this->appointment->updateData($input, $ap_id);
            if ($update == 1) {
                return $this->getSuccessResult([], 'Appointment update.', true);
            } else {
                return $this->getErrorMessage('Appointment not update, something is wrong.');
            }
        } else {
            return redirect()->route('appointment.edit', base64_encode($ap_id));
        }
    }

    public function appointmentDocView($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        if (!empty($data)) {
            $docList = $this->ap_doc->getList(['ap_id' => $ap_id], false, 0, ['created_at', 'desc']);
            $view = view('appointment.appointment_doc_table_row_list', compact('docList'))->render();
            return $this->getSuccessResult($view, 'Appointment document detail found', true);
        } else {
            return $this->getErrorMessage('Appointment detail not found');
        }
    }

    public function appointmentDocSend(Request $request)
    {
        $input = $request->all();
        $ap_id = base64_decode($input['ap_id_doc']);

        $file = '';

        if ($request->hasFile('ap_doc')) {
            $fileName = $request->ap_doc->getClientOriginalName();
            $filteNameArr = explode('.', $fileName);
            $fileNameFinal = $filteNameArr[0] . '-' . $this->randomString(7, 'number');
            $fileNameFinal = str_replace(' ', '-', $fileNameFinal);
            // $file = UploadCustomeImage($request->file('ap_doc'), $ap_id . '-' . $this->randomString(10, 'number'));
            $file = UploadCustomeImage($request->file('ap_doc'), $fileNameFinal);
        }
        $data = [
            'ap_id' => $ap_id,
            'ap_doc_name' => $input['ap_doc_name'],
            'ap_doc' => json_encode([$file])
        ];
        $insert = $this->ap_doc->insertData($data);
        if ($insert->id) {
            $docData = $this->ap_doc->singlData($insert->id);
            $view = view('appointment.appointment_doc_table_row', compact('docData'))->render();
            return $this->getSuccessResult($view, 'Document upload', true);
        } else {
            return $this->getErrorMessage('Document not uploaded, please try again');
        }
    }

    public function appointmentDocRemove($id)
    {
        $data = $this->ap_doc->singlData($id);
        $file = $data->ap_doc;
        $delete = $this->ap_doc->deleteData($id);
        if ($delete) {
            ImageRemove($file);
            return $this->getSuccessResult([], 'Document delete', true);
        } else {
            return $this->getErrorMessage('Document not delete, please try again');
        }
    }

    public function appointmentDocDownload($id)
    {
        $id = base64_decode($id);
        $data = $this->ap_doc->singlData($id);
        $docArr = json_decode($data->ap_doc);
        //$path = Storage::disk('public')->path($docArr[0]);
        $path = base_path('/') . 'storage/app/public/' . $docArr[0];
        Storage::disk('local')->put($docArr[0], file_get_contents($path));
        Storage::path($docArr[0]);
        return response()->download($path);
    }

    /* appointment status change */
    public function status($string_val)
    {
        $string_val_decode = base64_decode($string_val);
        $string_val_arr = explode('[]', $string_val_decode);

        $ap_id = base64_decode($string_val_arr[0]);
        $status = $string_val_arr[1];
        if ($ap_id != '' && ($status == 'pending' || $status == 'completed' || $status == 'cancelled')) {
            $data['ap_status'] = $status;
            if (count($string_val_arr) > 2) {
                $data['ap_status_reaason'] = $string_val_arr[2];
            }
            $update = $this->appointment->updateData($data, $ap_id);
            if ($update == 1) {
                return $this->getSuccessResult([], 'Status update.', true);
            } else {
                return $this->getErrorMessage('Status not update, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Status not update, something is wrong.');
        }
    }

    /* appointment full detail show */
    public function view($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $added_by = $data->AddedByData->person_name;
            $data1['added_by_user'] = $added_by;
            $updated_by = $data->UpdatedByData->person_name;
            $data1['updated_by_user'] = $updated_by;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['doctor_name'] = $data->doctorData->person_name;
            $data1['ap_date'] = date('d M Y', strtotime($data->ap_date));
            return $this->getSuccessResult($data1, 'Appointment detail found', true);
        } else {
            return $this->getErrorMessage('Appointment detail not found');
        }
    }

    /* Export Appointment */
    public function export(Request $request)
    {
        $input = $request->query();
        $login_user_id = Auth::user()->user_id;
        $fileName = 'Appointment-' . $login_user_id . '-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new AppointmentExport($input), $fileName);
    }

    /* Bill Print */
    public function bill_print($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        return response()->view('appointment.print', compact('data'));
    }

    /* Prescription BillPrint */
    public function prescription_bill_print($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        $prescribeMedicineList = $this->appointment_medicine->getList(['ap_id' => $ap_id]);

        $generalMedicines = $this->general_medicine->getActiveList();
        return response()->view('appointment.prescription_print', compact('data', 'prescribeMedicineList', 'generalMedicines'));
    }

    /* prescription detail show */
    public function prescribe($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        $prescribeMedicineList = $this->appointment_medicine->getList(['ap_id' => $ap_id]);

        $generalMedicines = $this->general_medicine->getActiveList();
        return view('appointment.prescribe', compact('data', 'generalMedicines', 'prescribeMedicineList'));
    }

    /* prescription store */
    public function prescribe_store(Request $request, $ap_id)
    {
        $input = $request->all();
        $ap_id = base64_decode($ap_id);
        if ($input['ap_is_foc'] == 'yes') {
            $input['ap_charge'] = 0;
        } else {
            $apData = $this->appointment->singlData($ap_id);
            $visitingFees = $this->visiting_fee->getList();
            foreach ($visitingFees as $fee) {
                if ($fee->vf_case_type == $apData->ap_case_type) {
                    $input['ap_charge'] = $fee->vf_fees;
                }
            }
        }
        $input['ap_status'] = 'completed';
        $update = $this->appointment->updateData($input, $ap_id);
        if ($update == 1) {
            $data = $this->appointment->singlData($ap_id);
            return $this->getSuccessResult($data, 'Prescription update.', true);
        } else {
            return $this->getErrorMessage('Prescription not update, something is wrong.');
        }
    }

    /* appointment medicine store */
    public function appointmentMedicineStore(Request $request)
    {
        $query = $request->query();
        $am_id = $this->getAppointmentMedicineID();
        $login_user_id = Auth::user()->user_id;

        $data['am_id'] = $am_id;
        $data['ap_id'] = base64_decode($query['ap_id']);
        $data['am_added_by'] = $login_user_id;
        $data['am_days'] = $query['am_days'];
        $data['am_timing'] = $query['am_timing'];
        $data['am_morning'] = $query['am_morning'];
        $data['am_afternoon'] = $query['am_afternoon'];
        $data['am_evening'] = $query['am_evening'];

        if ($query['gm_id_original'] == '') {
            $gm_id = $this->getUserID();
            $data1 = [
                'gm_id'           => $gm_id,
                'gm_added_by'     => $login_user_id,
                'gm_updated_by'   => $login_user_id,
                'gm_name'         => $query['gm_id'],
                'gm_company_name' => '',
                'gm_description' => '',
            ];
            $insertGeneralMedicine = $this->general_medicine->insertGeneralMedicine($data1);
            $data['gm_id'] = $insertGeneralMedicine->gm_id;
        } else {
            $data['gm_id'] = $query['gm_id_original'];
        }


        $query['ap_id'] = base64_decode($query['ap_id']);

        $query['am_id'] = $am_id;
        $login_user_id = Auth::user()->user_id;
        $query['am_added_by'] = $login_user_id;
        $insert = $this->appointment_medicine->insertData($data);
        if (isset($insert->am_id)) {
            $data = $this->appointment_medicine->singlData($insert->am_id);
            $data['medicine_name'] = $data->medicineData->gm_name . ' (' . $data->medicineData->gm_company_name . ')';
            return $this->getSuccessResult($data, 'Appointment Medicine added', true);
        } else {
            return $this->getErrorMessage('Appointment Medicine not added, something is wrong.');
        }
    }

    /* Search General Medicine List */
    public function searchGenerlMedicineList($rgm_name)
    {
        $rgm_name = base64_decode($rgm_name);
        $list = $this->general_medicine->getSearchList($rgm_name);
        if (!empty($list)) {
            return $this->getSuccessResult($list, ' General medicine found', true);
        } else {
            return $this->getErrorMessage('Search text not found.');
        }
    }

    /* Appointment medicine remove */
    public function appointmentMedicineRemove($am_id)
    {
        $am_id = base64_decode($am_id);
        $delete = $this->appointment_medicine->deleteData($am_id);
        if ($delete) {
            return $this->getSuccessResult([], 'Appointment Medicine removed', true);
        } else {
            return $this->getErrorMessage('Appointment Medicine not removed, something is wrong.');
        }
    }

    /* Patient all height, weight, bp */
    public function patientAllAppointment($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $appointmentList = $this->appointment->patientAllAppointment($pa_id);
        if (count($appointmentList->toArray()) > 0) {
            $HeightWeightBPRow = '';
            foreach ($appointmentList as $hwb) {
                $HeightWeightBPRow .= '<tr><td>' . date('d M Y', strtotime($hwb->ap_date)) . '</td><td>' . $hwb->ap_height . '</td><td>' . $hwb->ap_weight . '</td><td>' . $hwb->ap_bp . '</td></tr>';
            }
            return $this->getSuccessResult($HeightWeightBPRow, 'Patient Height, Weight, BP found', true);
        } else {
            return $this->getErrorMessage('Patient Height, Weight, BP not found.');
        }
    }

    /* Note Update */
    public function note_update(Request $request, $ap_id)
    {
        $input = $request->all();
        $ap_id = base64_decode($ap_id);
        $update = $this->appointment->updateData($input, $ap_id);
        if ($update == 1) {
            $data = $this->appointment->singlData($ap_id);
            return $this->getSuccessResult($data, 'Note update.', true);
        } else {
            return $this->getErrorMessage('Note not update, something is wrong.');
        }
    }

    public function getUniqueID()
    {
        $ap_id = $this->randomString(10, 'number');
        $check = $this->appointment->singlData($ap_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $ap_id;
        }
    }

    public function getAppointmentMedicineID()
    {
        $am_id = $this->randomString(10, 'number');
        $check = $this->appointment_medicine->singlData($am_id);
        if (!empty($check)) {
            $this->getAppointmentMedicineID();
        } else {
            return $am_id;
        }
    }

    public function getUserID()
    {
        $gm_id = $this->randomString(10, 'number');
        $check = $this->general_medicine->singlGeneralMedicine($gm_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $gm_id;
        }
    }
}
