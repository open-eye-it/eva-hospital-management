<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Patient;
use App\Models\User;
use App\Models\Room;
use App\Models\IpdDetail;
use App\Models\IpdOperativeNote;
use App\Models\OperationMedicine;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\IpdDocument;

use App\Exports\IPDDetailExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IpdDetailController extends MainController
{
    public $patient, $room, $ipd_doc, $ipd, $ipd_note, $operation_medicine, $appointment, $notification;
    public function __construct()
    {
        parent::__construct();
        $this->patient = new Patient;
        $this->room = new Room;
        $this->ipd_doc = new IpdDocument;
        $this->ipd = new IpdDetail;
        $this->ipd_note = new IpdOperativeNote;
        $this->operation_medicine = new OperationMedicine;
        $this->appointment = new Appointment;
        $this->notification = new Notification;
    }

    public function index(Request $request)
    {
        $userLogin = Auth::user();
        $userRole = $userLogin->roles->pluck('id')[0];
        $input = $request->all();
        $searchData['search_text']      = isset($input['search_text']) ? $input['search_text'] : '';
        // $searchData['admit_date_range'] = isset($input['admit_date_range']) ? $input['admit_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $searchData['admit_date_range'] = isset($input['admit_date_range']) ? $input['admit_date_range'] : '';
        $searchData['ipd_status']       = (isset($input['ipd_status']) && $input['ipd_status'] == 'all') ? '' : (isset($input['ipd_status']) ? $input['ipd_status'] : 'admit');
        $searchData['ipd_doctor']  = isset($input['ipd_doctor']) ? $input['ipd_doctor'] : (($userRole == 2) ? $userLogin->user_id : '');

        $doctorList = User::select('user_id', 'person_name')->role('doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->where('user_status', 1)->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);

        $list = $this->ipd->getList($searchData);
        return view('ipd.list', compact('list', 'searchData', 'doctors'));
    }

    /* Export IPD Detail */
    public function export(Request $request)
    {
        $input = $request->query();
        $login_user_id = Auth::user()->user_id;
        $fileName = 'IPDDetail-' . $login_user_id . '-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new IPDDetailExport($input), $fileName);
    }

    public function create()
    {
        $admitPatientList = $this->ipd->admitPatient()->toArray();
        $admitPatientArr = [];
        if (!empty($admitPatientList)) {
            foreach ($admitPatientList as $admitList) {
                $admitPatientArr[] = $admitList['pa_id'];
            }
        }
        $patientList = $this->patient->patientWithoutIPD($admitPatientArr);
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
        $login_user = Auth::user();
        $patientExist = $this->ipd->patientExist($input['pa_id'],);
        if (empty($patientExist)) {
            $rm_id = $input['rm_id'];
            $roomExist = $this->ipd->singleDataByColumn(['rm_id' => $rm_id, 'ipd_status' => 'admit']);
            if (empty($roomExist)) {
                $login_user_id = Auth::user()->user_id;
                $input['ipd_id'] = $this->getUniqueID();
                $input['ipd_added_by'] = $login_user_id;
                $input['ipd_updated_by'] = $login_user_id;
                $insert = $this->ipd->insertData($input);
                if (isset($insert->ipd_id)) {
                    $notificationData = [
                        'no_id' => $this->getUniqueID(),
                        'ipd_id' => $insert->ipd_id,
                        'no_type' => 2,
                        'no_subject' => notificationSubjectList('ipd_add'),
                        'no_message' => notificationMessageList('ipd_add'),
                        'no_icon'    => notificationIconList('ipd_add'),
                        'no_action'  => 'ipd_add_doctor',
                        'no_created_for' => $input['ipd_doctor'],
                        'no_created_by' => $login_user->user_id
                    ];
                    $this->notification->insertData($notificationData);


                    $ion_data = [
                        'ion_id' => $this->getOperativeNoteID(),
                        'ipd_id' => $insert->ipd_id,
                    ];
                    $this->ipd_note->insertData($ion_data);
                    $this->room->updateRoom(['rm_busy' => 1], $rm_id);
                    return $this->getSuccessResult([], 'IPD added', true);
                } else {
                    return $this->getErrorMessage('IPD not added, something is wrong.');
                }
            } else {
                return $this->getErrorMessage('Room already busy.');
            }
        } else {
            return $this->getErrorMessage('Patient already admit.');
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

    public function ipdDocView($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $docList = $this->ipd_doc->getList(['ipd_id' => $ipd_id], false, 0, ['created_at', 'desc']);
            $view = view('ipd.ipd_doc_table_row_list', compact('docList'))->render();
            return $this->getSuccessResult($view, 'IPD document detail found', true);
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    public function ipdDocSend(Request $request)
    {
        $input = $request->all();
        $ipd_id = base64_decode($input['ipd_id_doc']);

        $file = '';
        if ($request->hasFile('ipd_doc')) {
            $file = UploadCustomeImage($request->file('ipd_doc'), $ipd_id . '-' . $this->randomString(10, 'number'));
        }
        $data = [
            'ipd_id' => $ipd_id,
            'ipd_doc_name' => $input['ipd_doc_name'],
            'ipd_doc' => json_encode([$file])
        ];
        $insert = $this->ipd_doc->insertData($data);
        if ($insert->id) {
            $docData = $this->ipd_doc->singlData($insert->id);
            $view = view('ipd.ipd_doc_table_row', compact('docData'))->render();
            return $this->getSuccessResult($view, 'Document upload', true);
        } else {
            return $this->getErrorMessage('Document not uploaded, please try again');
        }
    }

    public function ipdDocRemove($id)
    {
        $data = $this->ipd_doc->singlData($id);
        $file = $data->ipd_doc;
        $delete = $this->ipd_doc->deleteData($id);
        if ($delete) {
            ImageRemove($file);
            return $this->getSuccessResult([], 'Document delete', true);
        } else {
            return $this->getErrorMessage('Document not delete, please try again');
        }
    }

    public function ipdDocDownload($id)
    {
        $id = base64_decode($id);
        $data = $this->ipd_doc->singlData($id);
        $docArr = json_decode($data->ipd_doc);
        //$path = Storage::disk('public')->path($docArr[0]);
        $path = base_path('/') . 'storage/app/public/' . $docArr[0];
        Storage::disk('local')->put($docArr[0], file_get_contents($path));
        Storage::path($docArr[0]);
        return response()->download($path);
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
            $data['ipd_discharge_date'] = (is_null($data->ipd_discharge_date)) ? '' : $data->ipd_discharge_date;
            $data['ipd_diagnosis'] = (is_null($data->ipd_diagnosis)) ? '' : $data->ipd_diagnosis;
            $data['ipd_investigations'] = (is_null($data->ipd_investigations)) ? '' : $data->ipd_investigations;
            $data['ipd_treatment_given'] = (is_null($data->ipd_treatment_given)) ? '' : $data->ipd_treatment_given;
            $data['ipd_treatment_discharge'] = (is_null($data->ipd_treatment_discharge)) ? '' : $data->ipd_treatment_discharge;
            return $this->getSuccessResult($data1, 'IPD detail found', true);
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    public function status($string_val)
    {
        $login_user = Auth::user();
        $string_val_decode = base64_decode($string_val);
        $string_val_arr = explode('[]', $string_val_decode);
        $ipd_id = base64_decode($string_val_arr[0]);
        $ipdData = $this->ipd->singlData($ipd_id);
        $status = $string_val_arr[1];
        if ($ipd_id != '' && ($status == 'admit' || $status == 'discharged' || $status == 'cancelled')) {
            $data['ipd_status'] = $status;
            if (count($string_val_arr) > 2) {
                if ($status == 'discharged') {
                    $data['ipd_cancel_reason'] = '';
                    $data['ipd_discharge_date'] = ($string_val_arr[3] == '') ? null : $string_val_arr[3];
                    $data['ipd_diagnosis'] = $string_val_arr[4];
                    $data['ipd_investigations'] = $string_val_arr[5];
                    $data['ipd_treatment_given'] = $string_val_arr[6];
                    $data['ipd_treatment_discharge'] = $string_val_arr[7];
                    $data['ipd_follow_up_date'] = ($string_val_arr[8] != '') ? $string_val_arr[8] : null;
                } else if ($status == 'cancelled') {
                    $data['ipd_cancel_reason'] = $string_val_arr[2];
                    $data['ipd_discharge_date'] = null;
                    $data['ipd_follow_up_date'] = null;
                    $data['ipd_diagnosis'] = '';
                    $data['ipd_investigations'] = '';
                    $data['ipd_treatment_given'] = '';
                    $data['ipd_treatment_discharge'] = '';
                } else {
                    $data['ipd_cancel_reason'] = '';
                    $data['ipd_discharge_date'] = null;
                    $data['ipd_follow_up_date'] = null;
                    $data['ipd_diagnosis'] = '';
                    $data['ipd_investigations'] = '';
                    $data['ipd_treatment_given'] = '';
                    $data['ipd_treatment_discharge'] = '';
                }
            }
            $update = $this->ipd->updateData($data, $ipd_id);
            if ($update == 1) {
                if ($status == 'discharged') {
                    $notificationData = [
                        'no_id' => $this->getUniqueID(),
                        'ipd_id' => $ipd_id,
                        'no_type' => 2,
                        'no_subject' => notificationSubjectList('ipd_discharge'),
                        'no_message' => notificationMessageList('ipd_discharge'),
                        'no_icon'    => notificationIconList('ipd_discharge'),
                        'no_action'  => 'ipd_discharge',
                        'no_created_for' => $ipdData->ipd_doctor,
                        'no_created_by' => $login_user->user_id
                    ];
                    $this->notification->insertData($notificationData);
                }
                $dataNew = $this->ipd->singlData($ipd_id);
                if ($ipd_id != '' && ($status == 'discharged' || $status == 'cancelled')) {
                    $this->room->updateRoom(['rm_busy' => 0], $dataNew->rm_id);
                } else {
                    $this->room->updateRoom(['rm_busy' => 1], $dataNew->rm_id);
                }
                return $this->getSuccessResult([], 'Status update.', true);
            } else {
                return $this->getErrorMessage('Status not update, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Status not update, something is wrong.');
        }
    }

    /* Bill Amount Update */
    public function BillAmountUpdate(Request $request, $ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $input = $request->query();
        $update = $this->ipd->updateData($input, $ipd_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Bill Amount update.', true);
        } else {
            return $this->getErrorMessage('Bill Amount not update, something is wrong.');
        }
    }

    /* IPD Operative Note Show */
    public function IPDOperativeNote($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ion_date'] = (is_null($data->operativNoteData->ion_date)) ? date('Y-m-d') : (string)$data->operativNoteData->ion_date;
            $data1['ion_note'] = (string)$data->operativNoteData->ion_note;
            return $this->getSuccessResult($data1, 'IPD detail found', true);
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    /* IPD Operative Note Update */
    public function IPDOperativeNoteUpdate(Request $request, $ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $input = $request->query();
        $update = $this->ipd_note->updateData($input, $ipd_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Operative Note update.', true);
        } else {
            return $this->getErrorMessage('Operative Note not update, something is wrong.');
        }
    }

    /* IPD Operative Note Print */
    public function IPDOperativeNotePrint($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $data1['patient_id'] = $data->patientData->pa_id;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ion_date'] = (is_null($data->operativNoteData->ion_date)) ? date('Y-m-d') : (string)$data->operativNoteData->ion_date;
            $data1['ion_note'] = (string)$data->operativNoteData->ion_note;
            $data1['doctor'] = $data->doctorData->person_name;

            //return $this->getSuccessResult($data1, 'IPD detail found', true);
            return response()->view('ipd.operative_note_print', compact('data1'));
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    /* IPD Operation Medicine Print */
    public function IPDOperationMedicinePrint($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $medicineList = $this->operation_medicine->getAllMedicine(['om_status' => 1]);
        $data = $this->ipd->singlData($ipd_id);
        if (count($data->toArray()) > 0) {
            $data1['patient_id'] = $data->patientData->pa_id;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ipd_id'] = $data->ipd_id;
            $data1['ipd_operation_medicine'] = json_decode($data->ipd_operation_medicine);
            $data1['ipd_operation_medicine_date'] = (is_null($data->ipd_operation_medicine_date)) ? date('Y-m-d') : (string)$data->ipd_operation_medicine_date;
            $data1['doctor'] = $data->doctorData->person_name;

            $final_data = [
                'medicineList' => $medicineList->toArray(),
                'data' => $data1
            ];
            return response()->view('ipd.operation_medicine_print', compact('data1', 'medicineList'));
            //return $this->getSuccessResult($final_data, 'IPD details not found, something is wrong.', true);
        } else {
            return $this->getErrorMessage('IPD details not found, something is wrong.');
        }
    }

    /* IPD Prescription View */
    public function PrescriptionView($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $medicineList = $this->operation_medicine->getAllMedicine(['om_status' => 1]);
        $data = $this->ipd->singlData($ipd_id);
        if (count($data->toArray()) > 0) {
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ipd_id'] = $data->ipd_id;
            $data1['ipd_operation_medicine'] = json_decode($data->ipd_operation_medicine);
            $data1['ipd_operation_medicine_date'] = (is_null($data->ipd_operation_medicine_date)) ? date('Y-m-d') : (string)$data->ipd_operation_medicine_date;

            $final_data = [
                'medicineList' => $medicineList->toArray(),
                'data' => $data1
            ];
            return $this->getSuccessResult($final_data, 'Operation medicine found.', true);
        } else {
            return $this->getErrorMessage('IPD details not found, something is wrong.');
        }
    }

    /* IPD Bill Print */
    public function IPDBillPrint($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $data1['patient_id'] = $data->patientData->pa_id;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ion_date'] = (is_null($data->operativNoteData->ion_date)) ? date('Y-m-d') : (string)$data->operativNoteData->ion_date;
            $data1['ion_note'] = (string)$data->operativNoteData->ion_note;
            $data1['doctor'] = $data->doctorData->person_name;
            $data1['room'] = $data->roomData->rm_building . '-' . $data->roomData->rm_floor . '-' . $data->roomData->rm_ward . '-' . $data->roomData->rm_no;

            //return $this->getSuccessResult($data1, 'IPD detail found', true);
            return response()->view('ipd.bill_print', compact('data1'));
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }

    /* IPD Prescription Update */
    public function PrescriptionUpdate(Request $request, $ipd_id)
    {
        $input = $request->all();
        $ipd_id = base64_decode($ipd_id);
        $medicine_list = base64_decode($input['medicine_arr']);
        $medicine_arr = explode(',', $medicine_list);
        $medicineList = $this->operation_medicine->getAllMedicine(['om_status' => 1]);
        $medicineList = $medicineList->toArray();
        $medicineData = [];
        if (count($medicineList) > 0) {
            foreach ($medicineList as $key => $val) {
                if ($medicine_arr[$key] != 0) {
                    $arr = ['medicine_id' => $val['om_id'], 'medicine_val' => $medicine_arr[$key]];
                    $medicineData[] = $arr;
                }
            }
        }
        $medicine = null;
        if (count($medicineData) > 0) {
            $medicine = json_encode($medicineData);
        }
        $data = [
            'ipd_operation_medicine_date' => $input['ipd_operation_medicine_date'],
            'ipd_operation_medicine' => $medicine
        ];
        $update = $this->ipd->updateData($data, $ipd_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Prescription update.', true);
        } else {
            return $this->getErrorMessage('Prescription not update, something is wrong.');
        }
    }

    /* Patient OPD History */
    public function OpdHistory($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $searchData['patient'] = $pa_id;
        $list = $this->appointment->getAllData($searchData);
        $total_fees = $this->appointment->totalFees($searchData);
        $total_additional_fees = $this->appointment->totalAdditionalFees($searchData);
        if (!empty($list)) {
            $tableRow = '';
            $i = 1;
            foreach ($list as $appointment) {
                $is_foc = ($appointment->ap_is_foc == 'yes') ? 'Yes' : 'No';
                $follow_up_date = ($appointment->ap_follow_up_date != '' || !empty($appointment->ap_follow_up_date)) ? date('d M Y', strtotime($appointment->ap_follow_up_date)) : '';
                $surgery_date = date('d M Y', strtotime($appointment->ap_surg_date));
                $tableRow .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $appointment->ap_id . '</td>
                    <td>' . date('d M Y', strtotime($appointment->ap_id)) . '</td>
                    <td>' . $appointment->pa_id . '</td>
                    <td>' . $appointment->patientData->pa_name . '</td>
                    <td>' . $appointment->ap_case_type . '</td>
                    <td>' . $is_foc . '</td>
                    <td>' . $appointment->ap_charge . '</td>
                    <td>' . $appointment->ap_additional_charge . '</td>
                    <td>' . $follow_up_date . '</td>
                    <td>' . $surgery_date . '</td>
                </tr>';
            }

            $data = [
                'list' => $tableRow,
                'total_fees' => $total_fees,
                'total_additional_fees' => $total_additional_fees
            ];
            return $this->getSuccessResult($data, 'OPD History found.', true);
        } else {
            return $this->getErrorMessage('OPD History not available.');
        }
    }

    /* Patient IPD History */
    public function IpdHistory($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $searchData['patient'] = $pa_id;
        $list = $this->ipd->getList($searchData, false);
        $totalBillAmount = $this->ipd->totalBillAmount($searchData);
        $totalReceivedAmount = $this->ipd->totalReceivedAmount($searchData);
        if (!empty($list)) {
            $tableRow = '';
            $i = 1;
            foreach ($list as $ipd) {
                $is_foc = ($ipd->ipd_is_foc == 'yes') ? 'Yes' : 'No';
                $is_mediclaim = ($ipd->ipd_mediclaim == 'yes') ? 'Yes' : 'No';
                $tableRow .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $ipd->ipd_id . '</td>
                    <td>' . date('d M Y', strtotime($ipd->ipd_admit_date)) . '</td>
                    <td>' . $ipd->roomData->rm_building . '-' . $ipd->roomData->rm_floor . '-' . $ipd->roomData->rm_ward . '-' . $ipd->roomData->rm_no . '</td>
                    <td>' . $ipd->patientData->pa_id . '</td>
                    <td>' . $ipd->patientData->pa_name . '</td>
                    <td>' . $ipd->patientData->pa_age . '</td>
                    <td>' . $ipd->patientData->pa_contact_no . '</td>
                    <td>' . $ipd->ipd_surgery_text . '</td>
                    <td>' . date('d M Y', strtotime($ipd->ipd_surgery_date)) . '</td>
                    <td>' . $ipd->doctorData->person_name . '</td>
                    <td>' . date('d M Y', strtotime($ipd->ipd_discharge_date)) . '</td>
                    <td>' . date('d M Y', strtotime($ipd->ipd_follow_up_date)) . '</td>
                    <td>' . $is_foc . '</td>
                    <td>' . $is_mediclaim . '</td>
                    <td>' . ucfirst($ipd->ipd_status) . '</td>
                    <td>' . $ipd->ipd_bill_amount . '</td>
                    <td>' . $ipd->ipd_received_amount . '</td>
                </tr>';
            }

            $data = [
                'list' => $tableRow,
                'total_bill' => $totalBillAmount,
                'total_received' => $totalReceivedAmount
            ];
            return $this->getSuccessResult($data, 'OPD History found.', true);
        } else {
            return $this->getErrorMessage('OPD History not available.');
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

    public function getOperativeNoteID()
    {
        $ion_id = $this->randomString(10, 'number');
        $check = $this->ipd_note->singlData($ion_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $ion_id;
        }
    }

    /* Note Update */
    public function note_update(Request $request, $ipd_id)
    {
        $input = $request->all();
        $ipd_id = base64_decode($ipd_id);
        $update = $this->ipd->updateData($input, $ipd_id);
        if ($update == 1) {
            $data = $this->ipd->singlData($ipd_id);
            return $this->getSuccessResult($data, 'Note update.', true);
        } else {
            return $this->getErrorMessage('Note not update, something is wrong.');
        }
    }
}
