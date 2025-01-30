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
        $searchData['rm_building']  = isset($input['rm_building']) ? $input['rm_building'] : '';
        $searchData['rm_floor']  = isset($input['rm_floor']) ? $input['rm_floor'] : '';
        $searchData['rm_ward']  = isset($input['rm_ward']) ? $input['rm_ward'] : '';
        $searchData['rm_no']  = isset($input['rm_no']) ? $input['rm_no'] : '';
        $list = $this->room->getList($searchData);

        $Buildings = $this->room->buildingList($searchData['rm_building']);
        $Floors = '';
        $Wards = '';
        $Rooms = '';
        if (isset($searchData['rm_building']) && $searchData['rm_building'] != '' && isset($searchData['rm_floor']) && $searchData['rm_floor'] != '') {
            $Floors = $this->room->floorList($searchData['rm_building']);
        }
        if (isset($searchData['rm_building']) && $searchData['rm_building'] != '' && isset($searchData['rm_floor']) && $searchData['rm_floor'] != '' && isset($searchData['rm_ward']) && $searchData['rm_ward'] != '') {
            $Wards = $this->room->wardList($searchData['rm_building'], $searchData['rm_floor']);
        }
        if (isset($searchData['rm_building']) && $searchData['rm_building'] != '' && isset($searchData['rm_floor']) && $searchData['rm_floor'] != '' && isset($searchData['rm_ward']) && $searchData['rm_ward'] != '' && isset($searchData['rm_no']) && $searchData['rm_no'] != '') {
            $Rooms = $this->room->roomList($searchData['rm_building'], $searchData['rm_floor'], $searchData['rm_ward']);
        }

        return view('room.list', compact('list', 'searchData', 'Buildings', 'Floors', 'Wards', 'Rooms'));
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
                // 'rm_busy'       => $input['rm_busy'],
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

    public function status(Request $request, $rm_id)
    {
        $rm_id = base64_decode($rm_id);
        $room = $this->room->singlRoom($rm_id);
        if (is_null($room)) {
            return $this->getErrorMessage('Room not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($room->rm_status == 1) {
            $data = [
                'updated_by' => $updated_by,
                'rm_status'     => 0,
            ];
            $message    = $room->rm_no . ' ' . 'is now disable';
        } else {
            $data = [
                'updated_by' => $updated_by,
                'rm_status'     => 1,
            ];
            $message    = $room->rm_no . ' ' . 'is now enable';
        }

        $update = $this->room->updateRoom($data, $rm_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }

    public function floorFilter($rm_building)
    {
        $rm_building = base64_decode($rm_building);
        $Floors = $this->room->floorFilter($rm_building);
        $onClickMethod = "getWardFilter('" . $rm_building . "',this.value)";
        $option = '<label>Floor</label><select name="rm_floor" id="rm_floor" class="form-control" onchange="' . $onClickMethod . '">';
        $option .= '<option value="">-select-</option>';
        if (!empty($Floors)) {
            foreach ($Floors as $floor) {
                $option .= '<option value="' . $floor->rm_floor . '">' . $floor->rm_floor . '</option>';
            }
        }
        $option .= '</select>';
        $message = 'Floor Found';
        return $this->getSuccessResult($option, $message, true);
    }

    public function wardFilter($rm_building, $rm_floor)
    {
        $rm_building = base64_decode($rm_building);
        $rm_floor = base64_decode($rm_floor);
        $Wards = $this->room->wardFilter($rm_building, $rm_floor);
        $onClickMethod = "getRoomFilter('" . $rm_building . "', '" . $rm_floor . "',this.value)";
        $option = '<label>Ward</label><select name="rm_ward" id="rm_ward" class="form-control" onchange="' . $onClickMethod . '">';
        $option .= '<option value="">-select-</option>';
        if (!empty($Wards)) {
            foreach ($Wards as $ward) {
                $option .= '<option value="' . $ward->rm_ward . '">' . $ward->rm_ward . '</option>';
            }
        }
        $option .= '</select>';
        $message = 'Ward Found';
        return $this->getSuccessResult($option, $message, true);
    }

    public function roomFilter($rm_building, $rm_floor, $rm_ward)
    {
        $rm_building = base64_decode($rm_building);
        $rm_floor = base64_decode($rm_floor);
        $rm_ward = base64_decode($rm_ward);
        $Rooms = $this->room->roomFilter($rm_building, $rm_floor, $rm_ward);
        $option = '<label>Room</label><select name="rm_no" id="rm_no" class="form-control">';
        $option .= '<option value="">-select-</option>';
        if (!empty($Rooms)) {
            foreach ($Rooms as $room) {
                $option .= '<option value="' . $room->rm_no . '">' . $room->rm_no . '</option>';
            }
        }
        $option .= '</select>';
        $message = 'Room Found';
        return $this->getSuccessResult($option, $message, true);
    }
}
