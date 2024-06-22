<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class RoomController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->room = new Room;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->room->getList($searchData);
        return view('room.list', compact('list', 'searchData'));
    }

    public function create()
    {
        return view('room.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $checkBuildingFloorWardRoomExist = $this->room->checkBuildingFloorWardRoomExist($input['rm_building'], $input['rm_floor'], $input['rm_ward'], $input['rm_no']);
        if (empty($checkBuildingFloorWardRoomExist)) {
            $rm_id = $this->getUserID();
            $login_user_id = Auth::user()->user_id;
            $data = [
                'rm_id'         => $rm_id,
                'rm_added_by'   => $login_user_id,
                'rm_updated_by' => $login_user_id,
                'rm_building'   => $input['rm_building'],
                'rm_ward'       => $input['rm_ward'],
                'rm_floor'      => $input['rm_floor'],
                'rm_no'         => $input['rm_no'],
                'rm_charge'     => $input['rm_charge'],
                'rm_busy'       => $input['rm_busy'],
            ];
            $insert = $this->room->insertRoom($data);
            if (isset($insert->rm_id)) {
                return $this->getSuccessResult([], $input['rm_no'] . ' added to room', true);
            } else {
                return $this->getErrorMessage($input['rm_no'] . ' not added to room, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Same Building, Floor, Ward And Room No Already exist.');
        }
    }

    public function getUserID()
    {
        $rm_id = $this->randomString(10, 'number');
        $check = $this->room->singlRoom($rm_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $rm_id;
        }
    }

    public function edit(Request $request, $rm_id)
    {
        $rm_id = base64_decode($rm_id);
        $data = $this->room->singlRoom($rm_id);
        return view('room.edit', compact('data'));
    }

    public function update(Request $request, $rm_id)
    {
        $input = $request->all();
        $rm_id = base64_decode($rm_id);
        $updated_by = Auth::user()->user_id;
        $roomData = $this->room->singlRoom($rm_id);
        if (!empty($roomData)) {
            $checkBuildingFloorWardRoomExist = $this->room->checkBuildingFloorWardRoomExistIgnore_rm_id($rm_id, $input['rm_building'], $input['rm_floor'], $input['rm_ward'], $input['rm_no']);
            if (empty($checkBuildingFloorWardRoomExist)) {
                $data = [
                    'rm_building'   => $input['rm_building'],
                    'rm_ward'       => $input['rm_ward'],
                    'rm_floor'      => $input['rm_floor'],
                    'rm_no'         => $input['rm_no'],
                    'rm_charge'     => $input['rm_charge'],
                    'rm_busy'       => $input['rm_busy'],
                    'rm_updated_by' => $updated_by,
                ];
                $update = $this->room->updateRoom($data, $rm_id);
                if ($update == 1) {
                    return $this->getSuccessResult([], $input['rm_no'] . ' updated to room', true);
                } else {
                    return $this->getErrorMessage($input['rm_no'] . ' not updated to room, something is wrong.');
                }
            } else {
                return $this->getErrorMessage('Same Building, Floor, Ward And Room No Already exist.');
            }
        } else {
            return $this->getErrorMessage('Room not found.');
        }
    }
}
