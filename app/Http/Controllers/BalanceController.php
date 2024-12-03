<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;
use App\Models\AppointmentAdditionalCharge;

class BalanceController extends MainController
{
    public $appointment_model, $additonal_change_model;
    public function __construct()
    {
        parent::__construct();
        $this->appointment_model = new Appointment;
        $this->additonal_change_model = new AppointmentAdditionalCharge;
    }

    /* =============== Start:: OPD =============== */
    public function OPDBalance(Request $request)
    {
        $input = $request->query();
        $searchData['search_text']             = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : '';
        $total_fees = $this->totalFees($searchData);
        $total_additional_fees = $this->totalAdditionalFees($searchData);

        return view('balance.opd.list', compact('searchData', 'total_fees', 'total_additional_fees'));
    }

    /* Total of Charge */
    public function totalFees($searchData)
    {
        $total_fees = $this->appointment_model->totalFees($searchData);
        return $total_fees;
    }

    /* Total of Additional Charge */
    public function totalAdditionalFees($searchData)
    {
        $total_fees = $this->appointment_model->totalAdditionalFees($searchData);
        return $total_fees;
    }
    /* =============== End:: OPD =============== */

    /* =============== Start:: IPD =============== */
    public function IPDBalance(Request $request) {}
    /* =============== Etart:: IPD =============== */
}
