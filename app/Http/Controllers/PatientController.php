<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $checkEmail = $this->patient->checkEmailExist($input['pa_email']);
        if (count($checkEmail) == 0) {
            $checkContact = $this->patient->checkContactNoExist($input['pa_contact_no']);
            if (count($checkContact) == 0) {
                $checkAltContact = $this->patient->checkAltContactNoExist($input['pa_alt_contact_no']);
                if (count($checkAltContact) == 0) {
                    $pa_id = $this->getUniqueID();
                    $login_user_id = Auth::user()->user_id;
                    $file = '';
                    if ($request->hasFile('pa-photo')) {
                        $file = UploadCustomeImage($request->file('pa_photo'), $pa_id . '-' . $this->randomString(10, 'number'));
                    }

                    $input['pa_id'] = $pa_id;
                    $input['pa_added_by'] = $login_user_id;
                    $input['pa_updated_by'] = $login_user_id;
                    $input['pa_photo'] = $file;

                    $insert = $this->patient->insertData($input);
                    if (isset($insert->pa_id)) {
                        return $this->getSuccessResult([], $input['pa_name'] . ' added as Patient', true);
                    } else {
                        return $this->getErrorMessage($input['pa_name'] . ' not added as patient, something is wrong.');
                    }
                } else {
                    return $this->getErrorMessage($input['pa_alt_contact_no'] . ' already exist.');
                }
            } else {
                return $this->getErrorMessage($input['pa_contact_no'] . ' already exist.');
            }
        } else {
            return $this->getErrorMessage($input['pa_email'] . ' already exist.');
        }
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function getUniqueID()
    {
        $pa_id = $this->randomString(10, 'number');
        $check = $this->patient->singlData($pa_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $pa_id;
        }
    }
}
