<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\VisitingFee;

class AppointmentController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->appointment = new Appointment;
        $this->patient = new Patient;
        $this->user = new User;
        $this->visiting_fee = new VisitingFee;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $list = $this->appointment->getList($searchData);
        return view('appointment.list', compact('list', 'searchData'));
    }

    public function create()
    {
        $patientList = $this->patient->getList();
        $doctorList = User::select('user_id', 'person_name')->role('doctor')->orderBy('id', 'asc')->get()->toArray();
        $assDoctorList = User::select('user_id', 'person_name')->role('assistant_doctor')->orderBy('id', 'asc')->get()->toArray();
        $doctors = array_merge($doctorList, $assDoctorList);
        $visitingFees = $this->visiting_fee->getList();
        return view('appointment.create', compact('patientList', 'doctors', 'visitingFees'));
    }

    public function store()
    {
    }
}
