<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CategoryController extends MainController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $input       = $request->all();

        $this->validate($request, [
            'search_text'   => 'nullable|max:20',
        ]);

        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        if (isset($input['search_text']) && $input['search_text'] != null) {
            $roles =  Role::where('display_name', 'LIKE', '%' . $searchData . '%')->paginate(10);
        } else {
            $roles    = Role::orderBy('created_at', 'DESC')->paginate(10);
        }

        return view('category.list', compact('roles', 'searchData'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('category.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $existData = Role::where('name', $input['name'])->first();

        $create = 1;
        if (!is_null($existData)) {
            $create = 0;
            $message = $input['name'] . ' is already exist.';
        } else {
            $roleData['display_name']    = $input['display_name'];
            $roleData['name']            = $input['name'];

            $role = Role::create($roleData);

            $permisionArray    = $input['permission'];
            if (!is_null($permisionArray)) {
                $role->syncPermissions($permisionArray);
            }
            $message = $input['display_name'] . ' added to category';
        }

        if ($create == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }

    public function edit(Request $request, $id)
    {
        $role_id = base64_decode($id);
        $roleData    = Role::where("id", $role_id)->first();
        if (is_null($roleData)) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        }
        $permission = Permission::orderBy('section')->get();
        // echo "<pre>";
        // print_r($permission->toArray());
        // die;
        return view('category.edit', compact('roleData', 'permission'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $id = base64_decode($id);
        $roleData    = Role::find($id);
        $update = 1;
        if (is_null($roleData)) {
            $update = 0;
            $message = $input['cat_name'] . ' not updated to category, something is wrong.';
        }
        $roleData->display_name = $input['display_name'];
        $roleData->save();

        $permisionArray = array();
        if (!is_null($input['permission'])) {
            $permisionArray = $input['permission'];
        }

        if (!is_null($permisionArray)) {
            $roleData->syncPermissions($permisionArray);
        }

        if ($update == 1) {
            return $this->getSuccessResult([], $input['display_name'] . ' updated to category', true);
        } else {
            return $this->getErrorMessage($input['display_name'] . ' not updated to category, something is wrong.');
        }
    }

    public function status(Request $request, $id)
    {
        $id = base64_decode($id);
        $roleData    = Role::find($id);
        $update = 1;
        if (is_null($roleData)) {
            $update = 0;
            $message = 'Category not found';
        }
        $user_id = Auth::user()->user_id;
        if ($roleData->role_status == 1) {
            $roleData->role_status = 0;
            $message    = $roleData->display_name . ' ' . 'category is now disable';
        } else {
            $roleData->role_status = 1;
            $message    = $roleData->display_name . ' ' . 'category is now enable';
        }
        $roleData->save();
        if ($update == 1) {
            return $this->getSuccessResult([], $message, true);
        } else {
            return $this->getErrorMessage($message);
        }
    }
}
