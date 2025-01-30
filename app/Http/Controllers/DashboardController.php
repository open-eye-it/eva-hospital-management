<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Appointment;
use App\Models\IpdDetail;
use App\Models\Patient;

class DashboardController extends Controller
{
    public $user, $appointment, $ipd_detail, $patient;
    public function __construct()
    {
        $this->user        = new User;
        $this->appointment = new Appointment;
        $this->ipd_detail  = new IpdDetail;
        $this->patient     = new Patient;
    }

    public function index()
    {
        $user = Auth::user();
        $filterData = [];
        $filterData['appointment_date_range'] = date('Y-m-d') . ' - ' . date('Y-m-d');
        $filterData['admit_date_range']       = date('Y-m-d') . ' - ' . date('Y-m-d');
        if ($user->hasRole('doctor') || $user->hasRole('assistant_doctor')) {
            $filterData['doctor'] = $user->user_id;
            $filterData['ipd_doctor'] = $user->user_id;
        }
        $opdAllCount       = $this->appointment->getList([], false, '')->count();
        $ipdAllCount       = $this->ipd_detail->getList([], false, '')->count();
        $patientAllCount   = $this->patient->getList([], false, '')->count();
        $opdTodayCount     = $this->appointment->getList($filterData, false, '')->count();
        $ipdTodayCount     = $this->ipd_detail->getList($filterData, false, '')->count();
        $patientTodayCount = $this->patient->getList(['created_at' => date('Y-m-d')], false, '')->count();

        return view('dashboard.dashboard', compact('opdAllCount', 'ipdAllCount', 'patientAllCount', 'opdTodayCount', 'ipdTodayCount', 'patientTodayCount'));
    }

    public function signout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('signin.show');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function change_password(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        if (Hash::check($input['old_password'], $user->password)) {
            $pass = Hash::make($input['password']);
            $update = $this->user->updateUser(['password' => $pass], $user->user_id);
            if ($update == 1) {
                return redirect()->route('profile')->with('success', 'Password changed');
            } else {
                return redirect()->route('profile')->with('error', 'Password not changed, please try again');
            }
            //updateUser
        } else {
            return redirect()->route('profile')->with('error', 'Current password not matched');
        }
    }
}
