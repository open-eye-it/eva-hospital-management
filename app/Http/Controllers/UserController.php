<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->user = new User;
        $this->Role = new Role;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->user->getList($searchData);
        return view('user.list', compact('list', 'searchData'));
    }

    public function create()
    {
        $roleData = $this->Role->where('role_status', 1)->orderBy('display_name')->pluck('display_name', 'name')->all();
        return view('user.create', compact('roleData'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $checkEmailorUser = $this->user->checkUserOrEmailExist($input['uname'], $input['email']);
        if (empty($checkEmailorUser)) {
            $user_id = $this->getUserID();
            $login_user_id = Auth::user()->user_id;
            $data = [
                'user_id'             => $user_id,
                'name'                => $input['uname'],
                'email'               => $input['email'],
                'password'            => HASH::make($input['password']),
                'person_name'         => $input['person_name'],
                'contactno'           => $input['contactno'],
                'address'             => $input['address'],
                'added_by'            => $login_user_id,
                'updated_by'          => $login_user_id,
                'user_status'         => 1,
                'show_to_doctor_list' => 1,
            ];
            $insert = $this->user->insertUser($data);
            if (isset($insert->user_id)) {
                $insert->assignRole($input['cat_id']);
                return $this->getSuccessResult([], $input['person_name'] . ' added to user', true);
            } else {
                return $this->getErrorMessage($input['person_name'] . ' not added to user, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('User Name or Email Already exist.');
        }
    }

    public function getUserID()
    {
        $user_id = $this->randomString(10, 'number');
        $check = $this->user->singlUser($user_id);
        if (!empty($check)) {
            $this->getUserID();
        } else {
            return $user_id;
        }
    }

    public function edit(Request $request, $user_id)
    {
        $user_id = base64_decode($user_id);
        $data = $this->user->singlUser($user_id);
        $roleData = $this->Role->where('role_status', 1)->pluck('display_name', 'name')->all();
        return view('user.edit', compact('data', 'roleData'));
    }

    public function update(Request $request, $user_id)
    {
        $input = $request->all();
        $user_id = base64_decode($user_id);
        $updated_by = Auth::user()->user_id;
        $userData = $this->user->singlUser($user_id);
        if (!empty($userData)) {
            $data = [
                'name'                => $input['uname'],
                'email'               => $input['email'],
                'person_name'         => $input['person_name'],
                'contactno'           => $input['contactno'],
                'address'             => $input['address'],
                'updated_by'          => $updated_by,
            ];
            $update = $this->user->updateUser($data, $user_id);
            if ($update == 1) {
                $userData->syncRoles($input['cat_id']);
                return $this->getSuccessResult([], $input['person_name'] . ' updated to user', true);
            } else {
                return $this->getErrorMessage($input['person_name'] . ' not updated to user, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('User not found.');
        }
    }

    public function status(Request $request, $user_id)
    {
        $user_id = base64_decode($user_id);
        $user = $this->user->singlUser($user_id);
        if (is_null($user)) {
            return $this->getErrorMessage('User not found');
        }
        $updated_by = Auth::user()->user_id;
        if ($user->user_status == 1) {
            $data = [
                'updated_by' => $updated_by,
                'user_status'     => 0,
            ];
            $message    = $user->person_name . ' ' . 'is now disable';
        } else {
            $data = [
                'updated_by' => $updated_by,
                'user_status'     => 1,
            ];
            $message    = $user->person_name . ' ' . 'is now enable';
        }
        $update = $this->user->updateStatus($data, $user_id);

        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }

    public function viewUser(Request $request, $user_id)
    {
        $user_id = base64_decode($user_id);
        $data = $this->user->singlUser($user_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $added_by = $data->AddedByData->person_name;
            $data1['added_by_user'] = $added_by;
            $updated_by = $data->UpdatedByData->person_name;
            $data1['updated_by_user'] = $updated_by;
            return $this->getSuccessResult($data1, 'User detail found', true);
        } else {
            return $this->getErrorMessage('User detail not found');
        }
    }
}
