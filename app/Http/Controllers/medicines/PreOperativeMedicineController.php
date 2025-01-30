<?php

namespace App\Http\Controllers\medicines;

use App\Http\Controllers\MainController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PreOperativeMedicine;

class PreOperativeMedicineController extends MainController
{
    public $pre_medicine;
    public function __construct()
    {
        $this->pre_medicine = new PreOperativeMedicine;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->pre_medicine->getList($searchData);
        return view('medicine.pre-medicine.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('medicine.pre-medicine.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $pom_id = $this->getUserID();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'pom_id'         => $pom_id,
            'pom_added_by'     => $login_user_id,
            'pom_updated_by'   => $login_user_id,
            'recommendation' => $input['recommendation'],
            'description' => $input['description'],
            'given_or_not' => $input['given_or_not'],
        ];
        $insert = $this->pre_medicine->insertData($data);
        if (isset($insert->pom_id)) {
            return $this->getSuccessResult([], $input['recommendation'] . ' added to pre operative medicine', true);
        } else {
            return $this->getErrorMessage($input['recommendation'] . ' not added to pre operative medicine, something is wrong.');
        }
    }

    public function getUserID()
    {
        $pom_id = $this->randomString(10, 'number');
        $check = $this->pre_medicine->singlData($pom_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $pom_id;
        }
    }

    public function edit(Request $request, $pom_id)
    {
        $pom_id = base64_decode($pom_id);
        $data = $this->pre_medicine->singlData($pom_id);
        return view('medicine.pre-medicine.edit', compact('data'));
    }

    public function update(Request $request, $pom_id)
    {
        $input = $request->all();
        $pom_id = base64_decode($pom_id);
        $updated_by = Auth::user()->user_id;
        $medicineData = $this->pre_medicine->singlData($pom_id);
        if (!empty($medicineData)) {
            $data = [
                'pom_updated_by' => $updated_by,
                'recommendation' => $input['recommendation'],
                'description' => $input['description'],
                'given_or_not' => $input['given_or_not']
            ];
            $update = $this->pre_medicine->updateData($data, ['pom_id' => $pom_id]);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['recommendation'] . ' updated to Pre Operative medicine', true);
            } else {
                return $this->getErrorMessage($input['recommendation'] . ' not updated to Pre Operative medicine, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Pre Operative Medicine not found.');
        }
    }

    public function status(Request $request, $pom_id)
    {
        $pom_id = base64_decode($pom_id);
        $medicine = $this->pre_medicine->singlData($pom_id);
        if (is_null($medicine)) {
            return $this->getErrorMessage('Pre Operative Medicine not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($medicine->pom_status == 1) {
            $data = [
                'pom_updated_by' => $updated_by,
                'pom_status'     => 0,
            ];
            $message    = $medicine->recommendation . ' ' . 'is now disable';
        } else {
            $data = [
                'pom_updated_by' => $updated_by,
                'pom_status'     => 1,
            ];
            $message    = $medicine->recommendation . ' ' . 'is now enable';
        }
        $update = $this->pre_medicine->updateData($data, ['pom_id' => $pom_id]);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }
}
