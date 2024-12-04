<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;
use App\Models\AppointmentAdditionalCharge;
use App\Models\IpdDetail;
use App\Models\IpdCharge;
use App\Models\IpdPaymentList;

class BalanceController extends MainController
{
    public $appointment_model, $additonal_change_model, $ipd_model, $ipd_payment_model;
    public function __construct()
    {
        parent::__construct();
        $this->appointment_model = new Appointment;
        $this->additonal_change_model = new AppointmentAdditionalCharge;
        $this->ipd_model = new IpdDetail;
        $this->ipd_payment_model = new IpdPaymentList;
    }

    /* =============== Start:: OPD =============== */
    public function OPDBalance(Request $request)
    {
        $input = $request->query();
        $searchData['search_text']             = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : '';
        $opd_total_fees = $this->totalFees($searchData);
        $opd_total_additional_fees = $this->totalAdditionalFees($searchData);

        $opd_total_cash = $this->appointment_model->getAllData(['ap_payment_mode' => 'cash'])->sum('ap_charge');
        $opd_total_additional_cash = $this->additonal_change_model->getAllData(['apac_payment_mode' => 'cash'])->sum('apac_final_charge');

        $opd_total_card = $this->appointment_model->getAllData(['ap_payment_mode' => 'card'])->sum('ap_charge');
        $opd_total_additional_card = $this->additonal_change_model->getAllData(['apac_payment_mode' => 'card'])->sum('apac_final_charge');

        $opd_total_mediclaim = $this->appointment_model->getAllData(['ap_payment_mode' => 'mediclaim'])->sum('ap_charge');
        $opd_total_additional_mediclaim = $this->additonal_change_model->getAllData(['apac_payment_mode' => 'mediclaim'])->sum('apac_final_charge');

        $opd_total_corporate = $this->appointment_model->getAllData(['ap_payment_mode' => 'corporate'])->sum('ap_charge');
        $opd_total_additional_corporate = $this->additonal_change_model->getAllData(['apac_payment_mode' => 'corporate'])->sum('apac_final_charge');

        return view('balance.opd.list', compact('searchData', 'opd_total_fees', 'opd_total_additional_fees', 'opd_total_cash', 'opd_total_additional_cash', 'opd_total_card', 'opd_total_additional_card', 'opd_total_mediclaim', 'opd_total_additional_mediclaim', 'opd_total_corporate', 'opd_total_additional_corporate'));
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
    public function IPDBalance(Request $request)
    {
        $input = $request->query();
        $searchData['search_text']      = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['admit_date_range'] = isset($input['admit_date_range']) ? $input['admit_date_range'] : '';
        $total_fees = $this->totalBillAmount($searchData);
        $total_received_fees = $this->totalReceivedAmount($searchData);

        $ipd_total_cash = $this->ipd_payment_model->getList(['ipl_received_by' => 'cash'])->sum('ipl_amount');
        $ipd_total_cheque = $this->ipd_payment_model->getList(['ipl_received_by' => 'cheque'])->sum('ipl_amount');
        $ipd_total_card = $this->ipd_payment_model->getList(['ipl_received_by' => 'card'])->sum('ipl_amount');

        return view('balance.ipd.list', compact('searchData', 'total_fees', 'total_received_fees', 'ipd_total_cash', 'ipd_total_cheque', 'ipd_total_card'));
    }


    /* Total of Charge */
    public function totalBillAmount($searchData)
    {
        $total_fees = $this->ipd_model->totalBillAmount($searchData);
        return $total_fees;
    }

    /* Total of Received Charge */
    public function totalReceivedAmount($searchData)
    {
        $total_fees = $this->ipd_model->totalReceivedAmount($searchData);
        return $total_fees;
    }
    /* =============== Etart:: IPD =============== */
}
