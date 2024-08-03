<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\IpdDetail;
use App\Models\VisitingFee;

class DoctorOpdIpdController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->appointment = new Appointment;
        $this->ipd = new IpdDetail;
        $this->visiting_fee = new VisitingFee;
    }
    /* OPE/IPD listing show */
    public function list(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        $patientList = $this->patient->getList();
        $visitingFees = $this->visiting_fee->getList();

        $filterData['date_range']  = isset($input['date_range']) ? $input['date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        /* OPD Fitler Data */
        $filterData['ap_doctor'] = $user->user_id;
        $filterData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $filterData['patient']  = isset($input['patient']) ? $input['patient'] : '';
        $filterData['appointment_date_range']  = isset($input['date_range']) ? $input['date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $filterData['case_type']  = isset($input['case_type']) ? $input['case_type'] : '';
        /* IPD Fitler Data */
        $filterData['ipd_doctor'] = $user->user_id;
        $filterData['admit_date_range'] = isset($input['date_range']) ? $input['date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        /* OPD List */
        $app_lists = $this->appointment->getList($filterData);
        /* IPD List */
        $ipd_lists = $this->ipd->getList($filterData);

        return view('doctor.opd-ipd.list', compact('app_lists', 'filterData', 'ipd_lists', 'patientList', 'visitingFees'));
    }
    /* OPD single view */
    public function opd_view($ap_id)
    {
        $ap_id = base64_decode($ap_id);
        $data = $this->appointment->singlData($ap_id);
        if (!empty($data->toArray())) {
            $design = view('doctor.opd.view', compact('data'))->render();
            return $this->getSuccessResult($design, 'OPD detail found', true);
        } else {
            return $this->getErrorMessage('OPD detail not found');
        }
    }
    /* IPD single view */
    public function ipd_view($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $data = $this->ipd->singlData($ipd_id);
        if (!empty($data->toArray())) {
            $design = view('doctor.ipd.view', compact('data'))->render();
            return $this->getSuccessResult($design, 'IPD detail found', true);
        } else {
            return $this->getErrorMessage('IPD detail not found');
        }
    }
}
