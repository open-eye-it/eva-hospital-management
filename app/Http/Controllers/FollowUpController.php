<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;
use App\Models\IpdDetail;

use App\Exports\FollowUpExport;
use Maatwebsite\Excel\Facades\Excel;

class FollowUpController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->appointment = new Appointment;
        $this->ipd = new IpdDetail;
    }

    /* OPD Follow-Up Info */
    public function index(Request $request)
    {
        $input = $request->query();

        $searchData['search_text']  = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['follow_up_date_range']  = isset($input['follow_up_date_range']) ? $input['follow_up_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $total_fees = $this->totalFees($searchData);

        $total_additional_fees = $this->totalAdditionalFees($searchData);
        $list = $this->appointment->getList($searchData);

        return view('follow-up.list', compact('list', 'searchData', 'total_fees', 'total_additional_fees'));
    }

    /* OPD Export Appointment */
    public function export(Request $request)
    {
        $input = $request->query();
        $login_user_id = Auth::user()->user_id;
        $fileName = 'FollowUp-' . $login_user_id . '-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new FollowUpExport($input), $fileName);
    }

    /* Total of Charge */
    public function totalFees($searchData)
    {
        $total_fees = $this->appointment->totalFees($searchData);
        return $total_fees;
    }

    /* Total of Additional Charge */
    public function totalAdditionalFees($searchData)
    {
        $total_fees = $this->appointment->totalAdditionalFees($searchData);
        return $total_fees;
    }

    /* IPD follow up info */
    public function ipd_index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']      = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['follow_up_date_range']  = isset($input['follow_up_date_range']) ? $input['follow_up_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $list = $this->ipd->getList($searchData);
        $total_bill_amount = $this->ipd->totalBillAmount($searchData);
        $total_received_amount = $this->ipd->totalReceivedAmount($searchData);
        return view('follow-up.ipd.list', compact('list', 'searchData', 'total_bill_amount', 'total_received_amount'));
    }

    /* IPD export  */
    public function ipd_export(Request $request)
    {
    }
}
