<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Patient;
use App\Models\ReferredDoctor;

class PatientController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->patient = new Patient;
        $this->referred_doctor = new ReferredDoctor;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['date']         = isset($input['date']) ? $input['date'] : '';
        $list = $this->patient->getList($searchData);
        return view('patient.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('patient.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // $checkEmail = $this->patient->checkEmailExist($input['pa_email']);
        // if (count($checkEmail) == 0) {
        //     $checkContact = $this->patient->checkContactNoExist($input['pa_contact_no']);
        //     if (count($checkContact) == 0) {
        // $checkAltContact = $this->patient->checkAltContactNoExist($input['pa_alt_contact_no']);
        // if (count($checkAltContact) == 0) {
        $pa_id = $this->getUniqueID();
        $login_user_id = Auth::user()->user_id;
        $file = '';

        if ($request->hasFile('pa_photo')) {
            $fileName = $request->pa_photo->getClientOriginalName();
            $filteNameArr = explode('.', $fileName);
            $fileNameFinal = $filteNameArr[0] . '-' . $this->randomString(7, 'number');
            $fileNameFinal = str_replace(' ', '-', $fileNameFinal);
            //$file = UploadCustomeImage($request->file('pa_photo'), $pa_id . '-' . $this->randomString(10, 'number'));
            $file = UploadCustomeImage($request->file('pa_photo'), $fileNameFinal);
        }
        if ($input['pa_referred_by'] != '') {
            /* Start::If Referred Doctor Not exist then create it */
            $doctorExist = $this->referred_doctor->singleDataByName($input['pa_referred_doctor']);
            $textExist = $this->referred_doctor->singleDataByName($input['pa_referred_text']);
            if ((empty($doctorExist) && $input['pa_referred_doctor'] != '') || (empty($textExist) && $input['pa_referred_text'] != '')) {
                $rd_name = '';
                if ($input['pa_referred_doctor'] != '') {
                    $rd_name = $input['pa_referred_doctor'];
                } else {
                    $rd_name = $input['pa_referred_text'];
                }
                $rd_id = $this->referredDoctorUniqueID();
                $data = [
                    'rd_id'           => $rd_id,
                    'rd_added_by'     => $login_user_id,
                    'rd_updated_by'   => $login_user_id,
                    'rd_name'         => $rd_name,
                ];
                if ($input['pa_referred_doctor'] == '' && $input['pa_referred_text'] != '') {
                    $input['pa_referred_doctor'] = $input['pa_referred_text'];
                }
                $insert = $this->referred_doctor->insertData($data);
            }
            /* End::If Referred Doctor Not exist then create it */
        }

        $input['pa_id'] = $pa_id;
        $input['pa_added_by'] = $login_user_id;
        $input['pa_updated_by'] = $login_user_id;
        $input['pa_photo'] = json_encode([$file]);

        $insert = $this->patient->insertData($input);
        if (isset($insert->pa_id)) {
            return $this->getSuccessResult(['pa_id' => $insert->pa_id], $input['pa_name'] . ' added as Patient', true);
        } else {
            return $this->getErrorMessage($input['pa_name'] . ' not added as patient, something is wrong.');
        }
        // } else {
        //     return $this->getErrorMessage($input['pa_alt_contact_no'] . ' already exist.');
        // }
        //     } else {
        //         return $this->getErrorMessage($input['pa_contact_no'] . ' already exist.');
        //     }
        // } else {
        //     return $this->getErrorMessage($input['pa_email'] . ' already exist.');
        // }
    }

    public function edit($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $data = $this->patient->singlData($pa_id);
        return view('patient.edit', compact('data'));
    }

    public function update(Request $request, $pa_id)
    {
        $input = $request->all();
        $pa_id = base64_decode($pa_id);
        // $checkEmail = $this->patient->checkEmailExistIgnoreID($input['pa_email'], $pa_id);
        // if (count($checkEmail) == 0) {
        //     $checkContact = $this->patient->checkContactNoExistIgnoreID($input['pa_contact_no'], $pa_id);
        //     if (count($checkContact) == 0) {
        $singleData = $this->patient->singlData($pa_id);
        $login_user_id = Auth::user()->user_id;
        $file = '';

        if ($request->hasFile('pa_photo')) {
            $fileName = $request->pa_photo->getClientOriginalName();
            $filteNameArr = explode('.', $fileName);
            $fileNameFinal = $filteNameArr[0] . '-' . $this->randomString(7, 'number');
            $fileNameFinal = str_replace(' ', '-', $fileNameFinal);
            // $file = UploadCustomeImage($request->file('pa_photo'), $pa_id . '-' . $this->randomString(10, 'number'));
            $file = UploadCustomeImage($request->file('pa_photo'), $fileNameFinal);
            ImageRemove($singleData->pa_photo);
        } else {
            $file = $singleData->pa_photo;
        }
        $doctorExist = $this->referred_doctor->singleDataByName($input['pa_referred_doctor']);
        $textExist = $this->referred_doctor->singleDataByName($input['pa_referred_text']);
        if ((empty($doctorExist) && $input['pa_referred_doctor'] != '') || (empty($textExist) && $input['pa_referred_text'] != '')) {
            $rd_name = '';
            if ($input['pa_referred_doctor'] != '') {
                $rd_name = $input['pa_referred_doctor'];
            } else {
                $rd_name = $input['pa_referred_text'];
            }
            $rd_id = $this->referredDoctorUniqueID();
            $data = [
                'rd_id'           => $rd_id,
                'rd_added_by'     => $login_user_id,
                'rd_updated_by'   => $login_user_id,
                'rd_name'         => $rd_name,
            ];
            if ($input['pa_referred_doctor'] == '' && $input['pa_referred_text'] != '') {
                $input['pa_referred_doctor'] = $input['pa_referred_text'];
            }
            $insert = $this->referred_doctor->insertData($data);
        }
        /* End::If Referred Doctor Not exist then create it */

        $input['pa_updated_by'] = $login_user_id;
        $input['pa_photo'] = json_encode([$file]);
        $update = $this->patient->updateData($input, $pa_id);
        if ($update == 1) {
            return $this->getSuccessResult([], $input['pa_name'] . ' updated as Patient', true);
        } else {
            return $this->getErrorMessage($input['pa_name'] . ' not updated as patient, something is wrong.');
        }
        //     } else {
        //         return $this->getErrorMessage($input['pa_contact_no'] . ' already exist.');
        //     }
        // } else {
        //     return $this->getErrorMessage($input['pa_email'] . ' already exist.');
        // }
    }

    public function status($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $patient = $this->patient->singlData($pa_id);
        if (is_null($patient)) {
            return $this->getErrorMessage('patient not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($patient->pa_status == 1) {
            $data = [
                'pa_updated_by' => $updated_by,
                'pa_status'     => 0,
            ];
            $message    = $patient->pa_name . ' ' . 'is now disable';
        } else {
            $data = [
                'pa_updated_by' => $updated_by,
                'pa_status'     => 1,
            ];
            $message    = $patient->pa_name . ' ' . 'is now enable';
        }
        $update = $this->patient->updateData($data, $pa_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }

    public function view($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $data = $this->patient->singlData($pa_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $added_by = $data->AddedByData->person_name;
            $data1['added_by_user'] = $added_by;
            $updated_by = $data->UpdatedByData->person_name;
            $data1['updated_by_user'] = $updated_by;
            $data1['photo'] = ImagePath($data->pa_photo);
            return $this->getSuccessResult($data1, 'Patient detail found', true);
        } else {
            return $this->getErrorMessage('Patient detail not found');
        }
    }

    public function getUniqueID()
    {
        //$pa_id = 'EVA' . date('Ymd') . $this->randomString(10, 'number');
        //$check = $this->patient->singlData($pa_id);
        $format = 'EVA' . date('Ymd');
        $pa_id = '';
        $patientCount = $this->patient->getList(['patient_id_start_month_year' => $format], false)->count();
        if ($patientCount > 0) {
            $pa_id = $format . ($patientCount + 1);
        } else {
            $pa_id = $format . '1';
        }
        $check = $this->patient->singlData($pa_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $pa_id;
        }
    }

    public function referredDoctorUniqueID()
    {
        $rd_id = $this->randomString(10, 'number');
        $check = $this->referred_doctor->singlData($rd_id);
        if (!empty($check)) {
            $this->referredDoctorUniqueID();
        } else {
            return $rd_id;
        }
    }

    public function printPatient($pa_id)
    {
        $pa_id = base64_decode($pa_id);
        $patientData = $this->patient->singlData($pa_id);
        return response()->view('patient.detail-print', compact('patientData'));
    }
}
