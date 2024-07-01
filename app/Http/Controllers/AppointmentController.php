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
use App\Models\GeneralMedicine;
use App\Models\AppointmentMedicine;

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
        $this->general_medicine = new GeneralMedicine;
        $this->appointment_medicine = new AppointmentMedicine;
    }

    /* appointment list show */
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

    /* appointment create */
    public function create()
    {
        $patientList = $this->patient->patientActiveList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();
        return view('appointment.create', compact('patientList', 'doctors', 'visitingFees'));
    }

    /* appointment store */
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
            $data1['doctor_name'] = $data->doctorData->pa_name;
            $data1['ap_date'] = date('d M Y', strtotime($data->ap_date));
            return $this->getSuccessResult($data1, 'Appointment detail found', true);
        } else {
            return $this->getErrorMessage('Appointment detail not found');
        }
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
        $update = $this->appointment->updateData($input, $ap_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Prescription update.', true);
        } else {
            return $this->getErrorMessage('Prescription not update, something is wrong.');
        }
    }

    /* appointment medicine store */
    public function appointmentMedicineStore(Request $request)
    {
        $query = $request->query();
        $query['ap_id'] = base64_decode($query['ap_id']);
        $am_id = $this->getAppointmentMedicineID();
        $query['am_id'] = $am_id;
        $login_user_id = Auth::user()->user_id;
        $query['am_added_by'] = $login_user_id;
        $insert = $this->appointment_medicine->insertData($query);
        if (isset($insert->am_id)) {
            $data = $this->appointment_medicine->singlData($insert->am_id);
            $data['medicine_name'] = $data->medicineData->gm_name . ' (' . $data->medicineData->gm_company_name . ')';
            return $this->getSuccessResult($data, 'Appointment Medicine added', true);
        } else {
            return $this->getErrorMessage('Appointment Medicine not added, something is wrong.');
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
}
