<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\ReferredDoctor;

use Illuminate\Support\Facades\Auth;

class ReferredDoctorController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->doctor = new ReferredDoctor;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['patient_date_range']  = isset($input['patient_date_range']) ? $input['patient_date_range'] : '';
        $list = $this->doctor->getList($searchData);
        // foreach ($list as $patientData) {
        //     echo "<pre>";
        //     $patients = $patientData->patientData;
        //     $count = 0;
        //     foreach ($patients as $patient) {
        //         $dateArr = explode(' - ', $searchData['patient_date_range']);
        //         $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
        //         $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));

        //         if (date('Y-m-d', strtotime($patient->created_at)) >= $dateArr[0] && date('Y-m-d', strtotime($patient->created_at)) <= $dateArr[1]) {
        //             $count += 1;
        //         }
        //     }
        // }
        // die;
        // echo "<pre>";
        // print_r($list);
        // die;
        return view('referred-doctor.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('referred-doctor.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $rd_id = $this->getUserID();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'rd_id'           => $rd_id,
            'rd_added_by'     => $login_user_id,
            'rd_updated_by'   => $login_user_id,
            'rd_name'         => $input['rd_name'],
        ];
        $insert = $this->doctor->insertData($data);
        if (isset($insert->rd_id)) {
            return $this->getSuccessResult([], $input['rd_name'] . ' added to referred doctor', true);
        } else {
            return $this->getErrorMessage($input['rd_name'] . ' not added to referred doctor, something is wrong.');
        }
    }

    public function getUserID()
    {
        $rd_id = $this->randomString(10, 'number');
        $check = $this->doctor->singlData($rd_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $rd_id;
        }
    }

    public function edit(Request $request, $rd_id)
    {
        $rd_id = base64_decode($rd_id);
        $data = $this->doctor->singlData($rd_id);
        return view('referred-doctor.edit', compact('data'));
    }

    public function update(Request $request, $rd_id)
    {
        $input = $request->all();
        $rd_id = base64_decode($rd_id);
        $login_user_id = Auth::user()->user_id;
        $medicineData = $this->doctor->singlData($rd_id);
        if (!empty($medicineData)) {
            $data = [
                'rd_updated_by'   => $login_user_id,
                'rd_name'         => $input['rd_name'],
            ];
            $update = $this->doctor->updateData($data, $rd_id);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['rd_name'] . ' updated to referred doctor', true);
            } else {
                return $this->getErrorMessage($input['rd_name'] . ' not updated to referred doctor, srdething is wrong.');
            }
        } else {
            return $this->getErrorMessage('referred doctor not found.');
        }
    }

    public function searchList($rd_name)
    {
        $rd_name = base64_decode($rd_name);
        $list = $this->doctor->getSearchList($rd_name);
        if (!empty($list)) {
            return $this->getSuccessResult($list, ' updated to referred doctor', true);
        } else {
            return $this->getErrorMessage('Search text not found.');
        }
    }
}
