<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Trainee;

class TraineeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->trainee = new Trainee();
    }

    public function index(Request $request)
    {
    }

    public function create()
    {
        $tr_real_id = $this->traineedID();
        return view('trainee.create', compact('tr_real_id'));
    }

    public function store()
    {
        $input = $request->all();
        $tr_id = $this->getUniqueID();
        $login_user_id = Auth::user()->user_id;
        print_r($input);
        die;
    }

    public function traineedID()
    {
        $tr_real_id = date('Y-m-d-His-') . '-' . $this->randomString(10, 'number');
        $check = $this->trainee->traineeIDExist($tr_real_id);
        if (!empty($check)) {
            $this->traineedID();
        } else {
            return $tr_real_id;
        }
    }

    public function getUniqueID()
    {
        $tr_id = $this->randomString(10, 'number');
        $check = $this->trainee->singlTrainee($tr_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $tr_id;
        }
    }
}
