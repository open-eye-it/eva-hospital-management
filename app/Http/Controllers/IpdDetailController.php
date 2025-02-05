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
use App\Models\IndoorSheet;
use App\Models\IndoorSheetMedicine;
use App\Models\IndoorSheetMedicineExamination;
use App\Models\IpdCharge;
use App\Models\PostOperativeMedicine;
use App\Models\IpdPreOperativeMedicine;
use App\Models\PreOperativeMedicine;

use App\Exports\IPDDetailExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IpdDetailController extends MainController
{
    public $patient, $room, $ipd_doc, $ipd, $ipd_note, $ipd_charge, $operation_medicine, $appointment, $notification, $indoor_sheet, $indoor_sheet_medicine, $indoor_sheet_medicine_examination, $post_medicine, $ipd_pre_operative_medicine, $pre_operative_medicine;
    public function __construct()
    {
        parent::__construct();
        $this->patient = new Patient;
        $this->room = new Room;
        $this->ipd_doc = new IpdDocument;
        $this->ipd = new IpdDetail;
        $this->ipd_note = new IpdOperativeNote;
        $this->ipd_charge = new IpdCharge;
        $this->operation_medicine = new OperationMedicine;
        $this->appointment = new Appointment;
        $this->notification = new Notification;
        $this->indoor_sheet = new IndoorSheet;
        $this->indoor_sheet_medicine = new IndoorSheetMedicine;
        $this->indoor_sheet_medicine_examination = new IndoorSheetMedicineExamination;
        $this->post_medicine = new PostOperativeMedicine;
        $this->ipd_pre_operative_medicine = new IpdPreOperativeMedicine;
        $this->pre_operative_medicine = new PreOperativeMedicine;
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

    public function create(Request $request)
    {
        $input = $request->all();
        $pa_id = isset($input['patient']) ? $input['patient'] : '';
        $pa_id = base64_decode($pa_id);

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
        return view('ipd.create', compact('pa_id', 'patientList', 'doctors', 'roomList'));
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
                $input['ipd_discount'] = 0;
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

                    $ipdChargeTextArr = [
                        'OPERATION CHARGES (SURGEON CHARGES)',
                        'THEATRE CHARGES',
                        '3D CAMERS CHARGE',
                        'HARMONIC INSTRUMENT CHARGE',
                        'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.',
                        'DOCTOR CHARGE',
                        'ROOM CHARGE (3 DAYS * 2000 RS)',
                    ];
                    for ($i = 0; $i < count($ipdChargeTextArr); $i++) {
                        $ipdChargeData = [
                            'ipd_id' => $insert->ipd_id,
                            'ic_id' => $this->getChargeUniqueID(),
                            'ic_text' => $ipdChargeTextArr[$i],
                            'ic_amount' => 0,
                            'ic_added_by' => $login_user->user_id
                        ];
                        $insert = $this->ipd_charge->insertData($ipdChargeData);
                    }

                    /* Start:: Indoor sheet Add */
                    $indoorSheedata = [
                        'is_id' => $this->getIndoorSheetUniqueID(),
                        'ipd_id' => $insert->ipd_id,
                        'is_added_by' => $login_user->user_id,
                        'is_date' => date('Y-m-d'),
                        'is_findings' => 'General'
                    ];
                    $insertIndoorSheetData = $this->indoor_sheet->insertData($indoorSheedata);
                    /* End:: Indoor sheet Add */
                    if ($insertIndoorSheetData->is_id) {
                        /* Start:: Indoor sheet medicine Add */
                        $postOperativelist = $this->post_medicine->getList([], false);
                        if (count($postOperativelist->toArray()) > 0) {
                            foreach ($postOperativelist as $postOperative) {
                                $indoorSheetMedicinedata = [
                                    'ism_id' => $this->getIndoorSheetMedicineUniqueID(),
                                    'is_id' => $insertIndoorSheetData->is_id,
                                    'ism_added_by' => $login_user->user_id,
                                    'ism_recommendation' => $postOperative->recommendation
                                ];
                                $insertIndoorSheeMedicineData = $this->indoor_sheet_medicine->insertData($indoorSheetMedicinedata);
                            }
                        }
                        /* End:: Indoor sheet medicine Add */
                    }

                    /* Start:: Pre Operative medicine Add */
                    $preMeidicineList = $this->pre_operative_medicine->getList([], false);
                    if (count($preMeidicineList->toArray()) > 0) {
                        foreach ($preMeidicineList as $preMedicine) {
                            $preMedicineData = [
                                'ipom_id' => $this->getPreOperativeMedicineUniqueID(),
                                'ipd_id' => $insert->ipd_id,
                                'pom_added_by' => $login_user->user_id,
                                'pom_updated_by' => $login_user->user_id,
                                'recommendation' => $preMedicine->recommendation,
                                'description' => $preMedicine->description,
                                'given_or_not' => $preMedicine->given_or_not
                            ];
                            $preMeidicneAdd = $this->ipd_pre_operative_medicine->insertData($preMedicineData);
                        }
                    }
                    /* End:: Pre Operative medicine Add */

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
            $fileName = $request->ipd_doc->getClientOriginalName();
            $filteNameArr = explode('.', $fileName);
            $fileNameFinal = $filteNameArr[0] . '-' . $this->randomString(7, 'number');
            $fileNameFinal = str_replace(' ', '-', $fileNameFinal);
            //$file = UploadCustomeImage($request->file('ipd_doc'), $ipd_id . '-' . $this->randomString(10, 'number'));
            $file = UploadCustomeImage($request->file('ipd_doc'), $fileNameFinal);
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

    /** Discharge Summary Print */
    public function IPDDischargeSummaryPrint($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $data1['patient_id'] = $data->patientData->pa_id;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['ion_note'] = (string)$data->operativNoteData->ion_note;

            //return $this->getSuccessResult($data1, 'IPD detail found', true);
            return response()->view('ipd.discharge_summary_print', compact('data1'));
        } else {
            return $this->getErrorMessage('IPD detail not found');
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
            $data1['patient_id'] = $data->patientData->pa_id;
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
            $ipdCharges = $this->ipd_charge->getList(['ipd_id' => $ipd_id], false);

            $data1 = $data->toArray();
            $data1['ipdCharges'] = $ipdCharges->toArray();
            $data1['patient_id'] = $data->patientData->pa_id;
            $data1['patient_name'] = $data->patientData->pa_name;
            $data1['patient_age'] = $data->patientData->pa_age;
            $data1['pan_card'] = $data->patientData->pa_pan_card;
            $data1['address'] = $data->patientData->pa_address;
            $data1['city'] = $data->patientData->pa_city;
            $data1['pincode'] = $data->patientData->pa_pincode;
            $data1['state'] = $data->patientData->pa_state;
            $data1['age'] = $data->patientData->pa_age;
            $data1['gender'] = $data->patientData->pa_gender;
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
                $surgery_date = ($appointment->ap_surg_date != null && $appointment->ap_surg_date != '') ? date('d M Y', strtotime($appointment->ap_surg_date)) : '';
                $tableRow .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $appointment->ap_id . '</td>
                    <td>' . date('d M Y', strtotime($appointment->ap_date)) . '</td>
                    <td>' . $appointment->pa_id . '</td>
                    <td>' . $appointment->patientData->pa_name . '</td>
                    <td>' . $appointment->ap_case_type . '</td>
                    <td>' . $is_foc . '</td>
                    <td>' . $appointment->ap_charge . '</td>
                    <td>' . $appointment->ap_additional_charge . '</td>
                    <td>' . $follow_up_date . '</td>
                    <td>' . $surgery_date . '</td>
                    <td><span id="prescriptionBillView" data-id="' . base64_encode($appointment->ap_id) . '" title="Prescription Bill"><i class="flaticon flaticon2-print icon-3x cursor_pointer"></i></span></td>
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
                $encodedIpdId = base64_encode($ipd->ipd_id);
                $surgery_date = ($ipd->ipd_surgery_date != null && $ipd->ipd_surgery_date != '') ? date('d M Y', strtotime($ipd->ipd_surgery_date)) : '';
                $discharge_date = ($ipd->ipd_discharge_date != null && $ipd->ipd_discharge_date != '') ? date('d M Y', strtotime($ipd->ipd_discharge_date)) : '';
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
                    <td>' . $surgery_date . '</td>
                    <td>' . $ipd->doctorData->person_name . '</td>
                    <td>' . $discharge_date . '</td>
                    <td>' . $ipd->ipd_bill_amount . '</td>
                    <td>' . $ipd->ipd_received_amount . '</td>
                    <td><span class="ipdPopupOperativeNote" id="operativeNoteView" data-id="' . $encodedIpdId . '" title="Operative Notes"><i class="flaticon flaticon-notes icon-3x cursor_pointer"></i></span></td>
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

    public function PreOperativeMedicinetList($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $ipdDetail = $this->ipd->singlData($ipd_id);
        $medicineList = $this->ipd_pre_operative_medicine->getList(['ipd_id' => $ipd_id], false, 0, ['created_at', 'desc']);
        if (count($medicineList->toArray()) > 0) {
            $view = view('ipd.pre-operative-medicine.list', compact('medicineList'))->render();
            $data = [
                'html' => $view,
                'ipdDetail' => $ipdDetail,
                'patientName' => $ipdDetail?->patientData?->pa_name
            ];
            return $this->getSuccessResult($data, 'Medicine found.', true);
        } else {
            $data = [
                'html' => '',
                'ipdDetail' => $ipdDetail,
                'patientName' => $ipdDetail?->patientData?->pa_name
            ];
            return $this->getSuccessResult($data, 'Medicine not available.', true);
        }
    }

    public function PreOperativeMedicinetCreate(Request $request)
    {
        $input = $request->all();
        $userLogin = Auth::user();
        if ($input['ipom_id'] == '') {
            // $checkDate = $this->indoor_sheet->singlDataByWhere(['ipd_id' => base64_decode($input['ipd_id']), 'is_date' => date('Y-m-d')]);
            // if(empty($checkDate)){
            $data = [
                'ipom_id' => $this->getPreOperativeMedicineUniqueID(),
                'ipd_id' => base64_decode($input['ipd_id']),
                'pom_added_by' => $userLogin->user_id,
                'pom_updated_by' => $userLogin->user_id,
                'recommendation' => $input['recommendation'],
                'given_or_not' => $input['given_or_not'],
                'description' => $input['description']
            ];
            $insertData = $this->ipd_pre_operative_medicine->insertData($data);
            if ($insertData->ipom_id) {
                $view = view('ipd.pre-operative-medicine.single', compact('insertData'))->render();
                $data = [
                    'html' => $view
                ];
                return $this->getSuccessResult($data, 'Pre Operative Medicine added.', true);
            } else {
                return $this->getErrorMessage('Pre Operative Medicine not added, pleaase try again.', false);
            }
            // }else{
            //     return $this->getErrorMessage('Today finding already added.', false);
            // }
        } else {
            $data = [
                'ipd_id' => base64_decode($input['ipd_id']),
                'pom_updated_by' => $userLogin->user_id,
                'recommendation' => $input['recommendation'],
                'given_or_not' => $input['given_or_not'],
                'description' => $input['description']
            ];
            $update = $this->ipd_pre_operative_medicine->updateData($data, ['ipom_id' => $input['ipom_id']]);
            return $this->getSuccessResult([], 'Pre Operative Medicine updated.', true);
        }
    }

    public function PreOperativeMedicinetRemove($ipom_id)
    {
        $ipom_id = base64_decode($ipom_id);
        $remove = $this->ipd_pre_operative_medicine->deleteData($ipom_id);
        if ($remove) {
            return $this->getSuccessResult([], 'Pre Operative Medicine remove.', true);
        } else {
            return $this->getErrorMessage('Pre Operative Medicine not removed, pleaase try again.', false);
        }
    }

    public function IndoorSheetList($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $ipdDetail = $this->ipd->singlData($ipd_id);
        $indoorSheeList = $this->indoor_sheet->getList(['ipd_id' => $ipd_id], false, 0, ['created_at', 'desc']);
        if (count($indoorSheeList->toArray()) > 0) {
            $view = view('ipd.indoor-sheet.list', compact('indoorSheeList'))->render();
            $data = [
                'html' => $view,
                'ipdDetail' => $ipdDetail,
                'patientName' => $ipdDetail?->patientData?->pa_name
            ];
            return $this->getSuccessResult($data, 'Findings found.', true);
        } else {
            $data = [
                'html' => '',
                'ipdDetail' => $ipdDetail,
                'patientName' => $ipdDetail?->patientData?->pa_name
            ];
            return $this->getSuccessResult($data, 'Findings not available.', true);
        }
    }

    public function IndoorSheetFindingsCreate(Request $request)
    {
        $input = $request->all();
        $userLogin = Auth::user();
        if ($input['is_id'] == '') {
            // $checkDate = $this->indoor_sheet->singlDataByWhere(['ipd_id' => base64_decode($input['ipd_id']), 'is_date' => date('Y-m-d')]);
            // if(empty($checkDate)){
            $data = [
                'is_id' => $this->getIndoorSheetUniqueID(),
                'ipd_id' => base64_decode($input['ipd_id']),
                'is_added_by' => $userLogin->user_id,
                'is_date' => date('Y-m-d'),
                'is_findings' => $input['is_findings']
            ];
            $insertData = $this->indoor_sheet->insertData($data);
            if ($insertData->is_id) {
                $view = view('ipd.indoor-sheet.single-findings', compact('insertData'))->render();
                $data = [
                    'html' => $view
                ];
                return $this->getSuccessResult($data, 'Finding added.', true);
            } else {
                return $this->getErrorMessage('Finding not added, pleaase try again.', false);
            }
            // }else{
            //     return $this->getErrorMessage('Today finding already added.', false);
            // }
        } else {
            $data = [
                'ipd_id' => base64_decode($input['ipd_id']),
                'is_added_by' => $userLogin->user_id,
                'is_findings' => $input['is_findings']
            ];
            $update = $this->indoor_sheet->updateData($data, $input['is_id']);
            return $this->getSuccessResult([], 'Finding updated.', true);
        }
    }

    public function IndoorSheetFindingsRemove($is_id)
    {
        $is_id = base64_decode($is_id);
        $remove = $this->indoor_sheet->deleteData($is_id);
        if ($remove) {
            return $this->getSuccessResult([], 'Finding remove.', true);
        } else {
            return $this->getErrorMessage('Findings not removed, pleaase try again.', false);
        }
    }

    public function IndoorSheetMedicineList($is_id)
    {
        $is_id = base64_decode($is_id);
        $indoorSheeList = $this->indoor_sheet_medicine->getList(['is_id' => $is_id], false, 0, ['created_at', 'desc']);
        if (count($indoorSheeList->toArray()) > 0) {
            $view = view('ipd.indoor-sheet.medicine.list', compact('indoorSheeList'))->render();
            $data = [
                'html' => $view
            ];
            return $this->getSuccessResult($data, 'Recommendations found.', true);
        } else {
            $data = [
                'html' => ''
            ];
            return $this->getSuccessResult($data, 'Recommendations not available.', true);
        }
    }

    public function IndoorSheetMedicineCreate(Request $request)
    {
        $input = $request->all();
        $userLogin = Auth::user();
        if ($input['ism_id'] == '') {
            $data = [
                'ism_id' => $this->getIndoorSheetMedicineUniqueID(),
                'is_id' => base64_decode($input['is_id']),
                'ism_added_by' => $userLogin->user_id,
                'ism_recommendation' => $input['ism_recommendation']
            ];
            $insertData = $this->indoor_sheet_medicine->insertData($data);
            if ($insertData->is_id) {
                $view = view('ipd.indoor-sheet.medicine.single-ism', compact('insertData'))->render();
                $data = [
                    'html' => $view
                ];
                return $this->getSuccessResult($data, 'Recommendation added.', true);
            } else {
                return $this->getErrorMessage('Recommendation not added, pleaase try again.', false);
            }
        } else {
            $data = [
                'is_id' => base64_decode($input['is_id']),
                'ism_added_by' => $userLogin->user_id,
                'ism_recommendation' => $input['ism_recommendation']
            ];
            $update = $this->indoor_sheet_medicine->updateData($data, $input['ism_id']);
            return $this->getSuccessResult([], 'Recommendation updated.', true);
        }
    }

    public function IndoorSheetMedicineRemove($ism_id)
    {
        $ism_id = base64_decode($ism_id);
        $remove = $this->indoor_sheet_medicine->deleteData($ism_id);
        if ($remove) {
            return $this->getSuccessResult([], 'Recommendadtion remove.', true);
        } else {
            return $this->getErrorMessage('Recommendadtion not removed, pleaase try again.', false);
        }
    }

    public function ExaminationSheetList($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $ipdDetail = $this->ipd->singlData($ipd_id);
        $indoorSheeList = $this->indoor_sheet->getList(['ipd_id' => $ipd_id], false, 0, ['created_at', 'desc']);
        if (count($indoorSheeList->toArray()) > 0) {
            $view = view('ipd.examination-sheet.list', compact('indoorSheeList'))->render();
            $data = [
                'html' => $view,
                'ipdDetail' => $ipdDetail,
                'patientName' => $ipdDetail?->patientData?->pa_name
            ];
            return $this->getSuccessResult($data, 'Findings found.', true);
        } else {
            $data = [
                'html' => ''
            ];
            return $this->getSuccessResult($data, 'Findings not available.', true);
        }
    }

    public function ExaminationSheetMedicineList($is_id)
    {
        $is_id = base64_decode($is_id);
        $indoorSheeList = $this->indoor_sheet_medicine->getList(['is_id' => $is_id], false, 0, ['created_at', 'asc']);
        $examintionList = $this->indoor_sheet_medicine_examination->getList(['is_id' => $is_id], false, 0, ['isme_given_datetime', 'desc']);
        if (count($indoorSheeList->toArray()) > 0) {
            $view = view('ipd.examination-sheet.medicine.list', compact('indoorSheeList'))->render();
            $view1 = view('ipd.examination-sheet.medicine1.list', compact('examintionList'))->render();
            $data = [
                'html' => $view,
                'html1' => $view1
            ];
            return $this->getSuccessResult($data, 'Recommendations found.', true);
        } else {
            $data = [
                'html' => ''
            ];
            return $this->getSuccessResult($data, 'Recommendations not available.', true);
        }
    }

    public function ExaminationSheetMedicineAdd(Request $request)
    {
        $input = $request->all();
        $userLogin = Auth::user();
        $view = '';
        foreach ($input['exm_checked'] as $key => $exm_checked) {
            if ($exm_checked == 1) {
                $data = [
                    'isme_id' => $this->getIndoorSheetMedicineExaminationUniqueID(),
                    'is_id' => $input['is_id'][$key],
                    'ism_recommendation' => $input['exm_id'][$key],
                    'isme_given_datetime' => date('Y-m-d H:i:s', strtotime($input['isme_given_datetime'][$key])),
                    'isme_created_datetime' => date('Y-m-d H:i:s'),
                    'remark' => $input['remark'][$key],
                    'isme_added_by' => $userLogin->user_id
                ];
                $insertData = $this->indoor_sheet_medicine_examination->insertData($data);
                $view1 = view('ipd.examination-sheet.medicine1.single-isme', compact('insertData'))->render();
                $view .= $view1;
            }
        }
        if ($view != '') {
            $data = [
                'html' => $view
            ];
            return $this->getSuccessResult($data, 'Recommendations added.', true);
        } else {
            return $this->getErrorMessage('Recommendation not selected, pleaase try again.', false);
        }
    }

    public function ExaminationSheetMedicineRemove($isme_id)
    {
        $isme_id = base64_decode($isme_id);
        $deleteData = $this->indoor_sheet_medicine_examination->deleteData($isme_id);
        if ($deleteData) {
            return $this->getSuccessResult([], 'Examination deleted.', true);
        } else {
            return $this->getErrorMessage('Examination not delete, pleaase try again.', false);
        }
    }

    public function ExaminationSheetMedicineEdit($isme_id)
    {
        $isme_id = base64_decode($isme_id);
        $singleData = $this->indoor_sheet_medicine_examination->singlData($isme_id);
        if (!empty($singleData)) {
            $date = date('Y-m-d', strtotime($singleData->isme_given_datetime));
            $time = date('H:i', strtotime($singleData->isme_given_datetime));
            $datetime = $date . 'T' . $time;
            $data = [
                'examinationData' => $singleData,
                'given_date' => $datetime
            ];
            return $this->getSuccessResult($data, 'Examination dt.', true);
        } else {
            return $this->getErrorMessage('Examination not found, pleaase try again.', false);
        }
    }

    public function ExaminationSheetMedicineUpdate(Request $request)
    {
        $input = $request->all();
        $userLogin = Auth::user();
        $data = [
            'isme_given_datetime' => date('Y-m-d H:i:s', strtotime($input['isme_given_datetime'])),
            'remark' => $input['remark'],
            'isme_created_datetime' => date('Y-m-d H:i:s'),
            'isme_added_by' => $userLogin->user_id
        ];
        $updateData = $this->indoor_sheet_medicine_examination->updateData($data, $input['isme_id']);
        if ($updateData) {
            $data = [
                'datetime' => date('d M Y, h:i a', strtotime($input['isme_given_datetime'])),
                'isme_created_datetime' => date('d M Y, h:i a'),
                'remark' => $input['remark'],
                'added_by' => $userLogin->person_name
            ];
            return $this->getSuccessResult($data, 'Examination updated.', true);
        } else {
            return $this->getErrorMessage('Examination not updated, pleaase try again.', false);
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

    public function getPreOperativeMedicineUniqueID()
    {
        $ipom_id = $this->randomString(10, 'number');
        $check = $this->ipd_pre_operative_medicine->singlData($ipom_id);
        if (!empty($check)) {
            $this->getPreOperativeMedicineUniqueID();
        } else {
            return $ipom_id;
        }
    }

    public function getIndoorSheetUniqueID()
    {
        $is_id = $this->randomString(10, 'number');
        $check = $this->indoor_sheet->singlData($is_id);
        if (!empty($check)) {
            $this->getIndoorSheetUniqueID();
        } else {
            return $is_id;
        }
    }

    public function getIndoorSheetMedicineUniqueID()
    {
        $ism_id = $this->randomString(10, 'number');
        $check = $this->indoor_sheet_medicine->singlData($ism_id);
        if (!empty($check)) {
            $this->getIndoorSheetMedicineUniqueID();
        } else {
            return $ism_id;
        }
    }

    public function getIndoorSheetMedicineExaminationUniqueID()
    {
        $isme_id = $this->randomString(10, 'number');
        $check = $this->indoor_sheet_medicine_examination->singlData($isme_id);
        if (!empty($check)) {
            $this->getIndoorSheetMedicineExaminationUniqueID();
        } else {
            return $isme_id;
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

    /* Get IPD Charge Unique ID */
    public function getChargeUniqueID()
    {
        $ic_id = $this->randomString(10, 'number');
        $check = $this->ipd_charge->singlData($ic_id);
        if (!empty($check)) {
            $this->getChargeUniqueID();
        } else {
            return $ic_id;
        }
    }
}
