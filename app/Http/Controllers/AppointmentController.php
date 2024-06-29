<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\VisitingFee;

use Illuminate\Support\Facades\Auth;

class AppointmentController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->appointment = new Appointment;
        $this->patient = new Patient;
        $this->user = new User;
        $this->visiting_fee = new VisitingFee;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $patientList = $this->patient->getList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();

        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['patient']  = isset($input['patient']) ? $input['patient'] : '';
        $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : '';
        $searchData['doctor']  = isset($input['doctor']) ? $input['doctor'] : '';
        $searchData['case_type']  = isset($input['case_type']) ? $input['case_type'] : '';
        $list = $this->appointment->getList($searchData);
        return view('appointment.list', compact('list', 'searchData', 'patientList', 'doctors', 'visitingFees'));
    }

    public function create()
    {
        $patientList = $this->patient->getList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();
        return view('appointment.create', compact('patientList', 'doctors', 'visitingFees'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $login_user_id = Auth::user()->user_id;

        $input['ap_id'] = $this->getUniqueID();
        $input['ap_added_by'] = $login_user_id;
        $input['ap_updated_by'] = $login_user_id;

        $case_type_arr = explode('-', $input['ap_case_type']);
        $input['ap_case_type'] = $case_type_arr[0];
        $input['ap_charge'] = $case_type_arr[1];

        $insert = $this->appointment->insertData($input);
        if (isset($insert->ap_id)) {
            return $this->getSuccessResult([], 'Appointment added', true);
        } else {
            return $this->getErrorMessage('Appointment not added, something is wrong.');
        }
    }

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
            $input['ap_charge'] = $case_type_arr[1];
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
            $data1['doctor_name'] = $data->doctorData->pa_name;
            $data1['ap_date'] = date('d M Y', strtotime($data->ap_date));
            return $this->getSuccessResult($data1, 'Appointment detail found', true);
        } else {
            return $this->getErrorMessage('Appointment detail not found');
        }
    }

    public function prescribe($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        return view('appointment.prescribe', compact('data'));
    }

    public function prescribe_store(Request $request, $ap_id)
    {
        $input = $request->all();
        $ap_id = base64_decode($ap_id);
        $update = $this->appointment->updateData($input, $ap_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Prescription update.', true);
        } else {
            return $this->getErrorMessage('Prescription not update, something is wrong.');
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
}
