<?php

namespace App\Http\Controllers\medicines;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;

use App\Models\GeneralMedicine;

use Illuminate\Support\Facades\Auth;

class GeneralMedicineController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->general_medicine = new GeneralMedicine;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->general_medicine->getList($searchData);
        return view('medicine.general-medicine.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('medicine.general-medicine.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $gm_id = $this->getUserID();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'gm_id'           => $gm_id,
            'gm_added_by'     => $login_user_id,
            'gm_updated_by'   => $login_user_id,
            'gm_name'         => $input['gm_name'],
            'gm_company_name' => $input['gm_company_name'],
            'gm_description' => $input['gm_description'],
        ];
        $insert = $this->general_medicine->insertGeneralMedicine($data);
        if (isset($insert->gm_id)) {
            return $this->getSuccessResult([], $input['gm_name'] . ' added to general medicine', true);
        } else {
            return $this->getErrorMessage($input['gm_name'] . ' not added to general medicine, something is wrong.');
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

    public function edit(Request $request, $gm_id)
    {
        $gm_id = base64_decode($gm_id);
        $data = $this->general_medicine->singlGeneralMedicine($gm_id);
        return view('medicine.general-medicine.edit', compact('data'));
    }

    public function update(Request $request, $gm_id)
    {
        $input = $request->all();
        $gm_id = base64_decode($gm_id);
        $updated_by = Auth::user()->user_id;
        $medicineData = $this->general_medicine->singlGeneralMedicine($gm_id);
        if (!empty($medicineData)) {
            $data = [
                'gm_updated_by'   => $updated_by,
                'gm_name'         => $input['gm_name'],
                'gm_company_name' => $input['gm_company_name'],
                'gm_description'  => $input['gm_description']
            ];
            $update = $this->general_medicine->updateGeneralMedicine($data, $gm_id);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['gm_name'] . ' updated to general medicine', true);
            } else {
                return $this->getErrorMessage($input['gm_name'] . ' not updated to general medicine, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('General Medicine not found.');
        }
    }

    public function status(Request $request, $gm_id)
    {
        $gm_id = base64_decode($gm_id);
        $medicine = $this->general_medicine->singlGeneralMedicine($gm_id);
        if (is_null($medicine)) {
            return $this->getErrorMessage('General Medicine not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($medicine->gm_status == 1) {
            $data = [
                'gm_updated_by' => $updated_by,
                'gm_status'     => 0,
            ];
            $message    = $medicine->gm_name . ' ' . 'is now disable';
        } else {
            $data = [
                'gm_updated_by' => $updated_by,
                'gm_status'     => 1,
            ];
            $message    = $medicine->gm_name . ' ' . 'is now enable';
        }
        $update = $this->general_medicine->updateStatus($data, $gm_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }
}
