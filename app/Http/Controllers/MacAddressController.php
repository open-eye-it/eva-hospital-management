<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\MacAddress;

class MacAddressController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->macaddress = new MacAddress;
    }

    public function index(Request $request)
    {
        $input = $request->query();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->macaddress->getList($searchData);
        return view('mac-address.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('mac-address.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $ma_id = $this->getUniqueID();
        $login_user_id = Auth::user()->user_id;
        $input['ma_id'] = $ma_id;
        $input['ma_added_by'] = $login_user_id;
        $input['ma_updated_by'] = $login_user_id;
        $insert = $this->macaddress->insertData($input);
        if (isset($insert->ma_id)) {
            return $this->getSuccessResult([], $input['ma_pc_name'] . ' added to mac address', true);
        } else {
            return $this->getErrorMessage($input['ma_pc_name'] . ' not added to mac address, something is wrong.');
        }
    }

    public function edit($ma_id)
    {
        $ma_id = base64_decode($ma_id);
        $data = $this->macaddress->singlData($ma_id);
        return view('mac-address.edit', compact('data'));
    }

    public function update(Request $request, $ma_id)
    {
        $input = $request->all();
        $ma_id = base64_decode($ma_id);
        $login_user_id = Auth::user()->user_id;
        $macAddressData = $this->macaddress->singlData($ma_id);
        if (!empty($macAddressData)) {
            $input['ma_updated_by'] = $login_user_id;
            $update = $this->macaddress->updateData($input, $ma_id);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['ma_pc_name'] . ' updated to mac address', true);
            } else {
                return $this->getErrorMessage($input['ma_pc_name'] . ' not updated to mac address, srdething is wrong.');
            }
        } else {
            return $this->getErrorMessage('mac addres not found.');
        }
    }

    public function status($ma_id)
    {
        $ma_id = base64_decode($ma_id);
        $macAddress = $this->macaddress->singlData($ma_id);
        if (is_null($macAddress)) {
            return $this->getErrorMessage('mac address not found');
        }
        $login_user_id = Auth::user()->user_id;
        if ($macAddress->ma_status == 1) {
            $data = [
                'ma_updated_by' => $login_user_id,
                'ma_status'     => 0,
            ];
            $message    = $macAddress->ma_pc_name . ' ' . 'is now disable';
        } else {
            $data = [
                'ma_updated_by' => $login_user_id,
                'ma_status'     => 1,
            ];
            $message    = $macAddress->ma_pc_name . ' ' . 'is now enable';
        }
        $update = $this->macaddress->updateData($data, $ma_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }

    public function remove($ma_id)
    {
        $ma_id = base64_decode($ma_id);
        $delete = $this->macaddress->deleteData($ma_id);
        return redirect()->route('mac_address.list');
    }

    public function getUniqueID()
    {
        $ma_id = $this->randomString(10, 'number');
        $check = $this->macaddress->singlData($ma_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $ma_id;
        }
    }
}
