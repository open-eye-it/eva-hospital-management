<?php

namespace App\Http\Controllers\medicines;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;

use App\Models\OperationMedicine;

use Illuminate\Support\Facades\Auth;

class OperationMedicineController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->operation_medicine = new OperationMedicine;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->operation_medicine->getList($searchData);
        return view('medicine.operation-medicine.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('medicine.operation-medicine.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $om_id = $this->getUserID();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'om_id'           => $om_id,
            'om_added_by'     => $login_user_id,
            'om_updated_by'   => $login_user_id,
            'om_name'         => $input['om_name'],
            'om_company_name' => $input['om_company_name'],
            'om_description' => $input['om_description'],
        ];
        $insert = $this->operation_medicine->insertOperationMedicine($data);
        if (isset($insert->om_id)) {
            return $this->getSuccessResult([], $input['om_name'] . ' added to operation medicine', true);
        } else {
            return $this->getErrorMessage($input['om_name'] . ' not added to operation medicine, something is wrong.');
        }
    }

    public function getUserID()
    {
        $om_id = $this->randomString(10, 'number');
        $check = $this->operation_medicine->singlOperationMedicine($om_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $om_id;
        }
    }

    public function edit(Request $request, $om_id)
    {
        $om_id = base64_decode($om_id);
        $data = $this->operation_medicine->singlOperationMedicine($om_id);
        return view('medicine.operation-medicine.edit', compact('data'));
    }

    public function update(Request $request, $om_id)
    {
        $input = $request->all();
        $om_id = base64_decode($om_id);
        $updated_by = Auth::user()->user_id;
        $medicineData = $this->operation_medicine->singlOperationMedicine($om_id);
        if (!empty($medicineData)) {
            $data = [
                'om_updated_by'   => $updated_by,
                'om_name'         => $input['om_name'],
                'om_company_name' => $input['om_company_name'],
                'om_description'  => $input['om_description']
            ];
            $update = $this->operation_medicine->updateOperationMedicine($data, $om_id);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['om_name'] . ' updated to operation medicine', true);
            } else {
                return $this->getErrorMessage($input['om_name'] . ' not updated to operation medicine, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('operation medicine not found.');
        }
    }

    public function status(Request $request, $om_id)
    {
        $om_id = base64_decode($om_id);
        $medicine = $this->operation_medicine->singlOperationMedicine($om_id);
        if (is_null($medicine)) {
            return $this->getErrorMessage('operation medicine not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($medicine->om_status == 1) {
            $data = [
                'om_updated_by' => $updated_by,
                'om_status'     => 0,
            ];
            $message    = $medicine->om_name . ' ' . 'is now disable';
        } else {
            $data = [
                'om_updated_by' => $updated_by,
                'om_status'     => 1,
            ];
            $message    = $medicine->om_name . ' ' . 'is now enable';
        }
        $update = $this->operation_medicine->updateStatus($data, $om_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }
}
