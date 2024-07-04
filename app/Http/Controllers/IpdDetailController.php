<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Patient;
use App\Models\User;
use App\Models\Room;
use App\Models\IpdDetail;

class IpdDetailController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->patient = new Patient;
        $this->room = new Room;
        $this->ipd = new IpdDetail;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->ipd->getList($searchData);
        return view('ipd.list', compact('list', 'searchData'));
    }

    public function create()
    {
        $patientList = $this->patient->patientActiveList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $roomList = $this->room->getList(['rm_status' => 1, 'rm_busy' => 0]);
        $roomList = $this->room->getListforIPD(['rm_status' => 1, 'rm_busy' => 0]);
        return view('ipd.create', compact('patientList', 'doctors', 'roomList'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $patientExist = $this->ipd->patientExist($input['pa_id'],);
        if (empty($patientExist)) {
            $rm_id = $input['rm_id'];
            $roomExist = $this->ipd->singleDataByColumn(['rm_id' => $rm_id]);
            if (empty($roomExist)) {
                $login_user_id = Auth::user()->user_id;
                $input['ipd_id'] = $this->getUniqueID();
                $input['ipd_added_by'] = $login_user_id;
                $input['ipd_updated_by'] = $login_user_id;
                $insert = $this->ipd->insertData($input);
                if (isset($insert->ipd_id)) {
                    $this->room->updateRoom(['rm_busy' => 1], $rm_id);
                    return $this->getSuccessResult([], 'IPD added', true);
                } else {
                    return $this->getErrorMessage('IPD not added, something is wrong.');
                }
            } else {
                return $this->getErrorMessage('Room already busy.');
            }
        } else {
            return $this->getErrorMessage('Patient already exist.');
        }
    }

    public function edit($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $patientList = $this->patient->patientActiveList();
            $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
            $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
            $doctors = array_merge($doctorList, $assDoctorList);
            $roomList = $this->room->getListIgnoreID(['rm_status' => 1, 'rm_busy' => 0, 'rm_id' => $data->rm_id]);
            return view('ipd.edit', compact('data', 'patientList', 'doctors', 'roomList'));
        } else {
            return redirect()->route('ipd.list');
        }
    }

    public function update(Request $request, $ipd_id)
    {
        $input = $request->all();
        $ipd_id = base64_decode($ipd_id);
        $rm_id = $input['rm_id'];
        $patientExist = $this->ipd->singleDataByColumnIgnoreCurrentIPDAndStatusNotRelease(['pa_id' => $input['pa_id']], $ipd_id);
        if (empty($patientExist)) {
            $roomExist = $this->ipd->singleDataByColumnIgnoreCurrentIPDAndStatusNotRelease(['rm_id' => $rm_id], $ipd_id);
            if (empty($roomExist)) {
                $login_user_id = Auth::user()->user_id;
                $input['ipd_updated_by'] = $login_user_id;
                $data = $this->ipd->singlData($ipd_id);
                /* release room id */
                $release_room_id = $data->rm_id;
                $update = $this->ipd->updateData($input, $ipd_id);
                if ($update) {
                    $this->room->updateRoom(['rm_busy' => 0], $release_room_id);
                    $this->room->updateRoom(['rm_busy' => 1], $rm_id);
                    return $this->getSuccessResult([], 'IPD update', true);
                } else {
                    return $this->getErrorMessage('IPD not update, something is wrong.');
                }
            } else {
                return $this->getErrorMessage('Room already busy.');
            }
        } else {
            return $this->getErrorMessage('Patient already exist.');
        }
    }

    public function view($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $data1['ipd_admit_date'] = date('d M Y', strtotime($data->ipd_admit_date));
            $added_by = $data->AddedByData->person_name;
            $data1['added_by_user'] = $added_by;
            $updated_by = $data->UpdatedByData->person_name;
            $data1['updated_by_user'] = $updated_by;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_dob'] = date('d M Y', strtotime($data->patientData->pa_dob));
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['patient_contact_no'] = $data->patientData->pa_contact_no;
            $data1['doctor_name'] = $data->doctorData->person_name;
            $data1['ap_date'] = date('d M Y', strtotime($data->ap_date));
            $data1['room_no'] = $data->roomData->rm_building . '-' . $data->roomData->rm_floor . '-' . $data->roomData->rm_ward . '-' . $data->roomData->rm_no;
            $data1['ipd_surgery_date'] = date('d M Y', strtotime($data->ipd_surgery_date));
            return $this->getSuccessResult($data1, 'IPD detail found', true);
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    public function status($string_val)
    {
        $string_val_decode = base64_decode($string_val);
        $string_val_arr = explode('[]', $string_val_decode);

        $ipd_id = base64_decode($string_val_arr[0]);
        $status = $string_val_arr[1];
        if ($ipd_id != '' && ($status == 'admit' || $status == 'discharged' || $status == 'cancelled')) {
            $data['ipd_status'] = $status;
            if (count($string_val_arr) > 2) {
                $data['ipd_cancel_reason'] = $string_val_arr[2];
            }
            $update = $this->ipd->updateData($data, $ipd_id);
            if ($update == 1) {
                return $this->getSuccessResult([], 'Status update.', true);
            } else {
                return $this->getErrorMessage('Status not update, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Status not update, something is wrong.');
        }
    }

    public function getUniqueID()
    {
        $ipd_id = $this->randomString(10, 'number');
        $check = $this->ipd->singlData($ipd_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $ipd_id;
        }
    }
}
