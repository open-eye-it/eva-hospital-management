<?php

namespace App\Http\Controllers\medicines;

use App\Http\Controllers\MainController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PostOperativeMedicine;

class PostOperativeMedicineController extends MainController
{
    public $post_medicine;
    public function __construct()
    {
        $this->post_medicine = new PostOperativeMedicine;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->post_medicine->getList($searchData);
        return view('medicine.post-medicine.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('medicine.post-medicine.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $poom_id = $this->getUserID();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'poom_id'         => $poom_id,
            'poom_added_by'     => $login_user_id,
            'poom_updated_by'   => $login_user_id,
            'recommendation' => $input['recommendation'],
        ];
        $insert = $this->post_medicine->insertData($data);
        if (isset($insert->poom_id)) {
            return $this->getSuccessResult([], $input['recommendation'] . ' added to Post Operative medicine', true);
        } else {
            return $this->getErrorMessage($input['recommendation'] . ' not added to Post Operative medicine, something is wrong.');
        }
    }

    public function getUserID()
    {
        $poom_id = $this->randomString(10, 'number');
        $check = $this->post_medicine->singlData($poom_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $poom_id;
        }
    }

    public function edit(Request $request, $poom_id)
    {
        $poom_id = base64_decode($poom_id);
        $data = $this->post_medicine->singlData($poom_id);
        return view('medicine.post-medicine.edit', compact('data'));
    }

    public function update(Request $request, $poom_id)
    {
        $input = $request->all();
        $poom_id = base64_decode($poom_id);
        $updated_by = Auth::user()->user_id;
        $medicineData = $this->post_medicine->singlData($poom_id);
        if (!empty($medicineData)) {
            $data = [
                'poom_updated_by' => $updated_by,
                'recommendation' => $input['recommendation'],
            ];
            $update = $this->post_medicine->updateData($data, ['poom_id' => $poom_id]);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['recommendation'] . ' updated to Post Operative medicine', true);
            } else {
                return $this->getErrorMessage($input['recommendation'] . ' not updated to Post Operative medicine, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Pre Operative Medicine not found.');
        }
    }

    public function status(Request $request, $poom_id)
    {
        $poom_id = base64_decode($poom_id);
        $medicine = $this->post_medicine->singlData($poom_id);
        if (is_null($medicine)) {
            return $this->getErrorMessage('Pre Operative Medicine not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($medicine->poom_status == 1) {
            $data = [
                'poom_updated_by' => $updated_by,
                'poom_status'     => 0,
            ];
            $message    = $medicine->recommendation . ' ' . 'is now disable';
        } else {
            $data = [
                'poom_updated_by' => $updated_by,
                'poom_status'     => 1,
            ];
            $message    = $medicine->recommendation . ' ' . 'is now enable';
        }
        $update = $this->post_medicine->updateData($data, ['poom_id' => $poom_id]);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }
}
