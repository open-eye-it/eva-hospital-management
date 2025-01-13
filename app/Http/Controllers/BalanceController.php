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
        $searchData['appointment_date_range']  = isset($input['date_range']) ? $input['date_range'] : '';
        $searchData['ap_charge_status'] = 'paid';
        $opd_total_fees = $this->totalFees($searchData);
        //$opd_total_additional_fees = $this->totalAdditionalFees($searchData);
        $opd_total_additional_fees = $this->appointment_model->getAllData($searchData)->sum('ap_additional_charge');

        $searchDataPending['search_text']             = isset($input['search_text']) ? $input['search_text'] : '';
        $searchDataPending['appointment_date_range']  = isset($input['date_range']) ? $input['date_range'] : '';
        $searchDataPending['ap_charge_status'] = 'pending';
        $opd_total_fees_pending = $this->totalFees($searchDataPending);

        $cashFilter = $searchData;
        $cashFilter['ap_payment_mode'] = 'cash';
        $cashFilter['apac_payment_mode'] = 'cash';
        $cashFilter['ap_charge_status'] = 'paid';
        $opd_total_cash = $this->appointment_model->getAllData($cashFilter)->sum('ap_charge');
        $opd_total_additional_cash = $this->additonal_change_model->getAllData($cashFilter)->sum('apac_final_charge');

        $cashPendingFilter = $searchData;
        $cashPendingFilter['ap_payment_mode'] = 'cash';
        $cashPendingFilter['ap_charge_status'] = 'pending';
        $opd_total_cash_pending = $this->appointment_model->getAllData($cashPendingFilter)->sum('ap_charge');

        $cardFilter = $searchData;
        $cardFilter['ap_payment_mode'] = 'card';
        $cardFilter['apac_payment_mode'] = 'card';
        $cardFilter['ap_charge_status'] = 'paid';
        $opd_total_card = $this->appointment_model->getAllData($cardFilter)->sum('ap_charge');
        $opd_total_additional_card = $this->additonal_change_model->getAllData($cardFilter)->sum('apac_final_charge');

        $cardPendingFilter = $searchData;
        $cardPendingFilter['ap_payment_mode'] = 'card';
        $cardPendingFilter['ap_charge_status'] = 'pending';
        $opd_total_card_pending = $this->appointment_model->getAllData($cardPendingFilter)->sum('ap_charge');

        $mediclaimFilter = $searchData;
        $mediclaimFilter['ap_payment_mode'] = 'mediclaim';
        $mediclaimFilter['apac_payment_mode'] = 'mediclaim';
        $mediclaimFilter['ap_charge_status'] = 'paid';
        $opd_total_mediclaim = $this->appointment_model->getAllData($mediclaimFilter)->sum('ap_charge');
        $opd_total_additional_mediclaim = $this->additonal_change_model->getAllData($mediclaimFilter)->sum('apac_final_charge');

        $mediclaimPendingFilter = $searchData;
        $mediclaimPendingFilter['ap_payment_mode'] = 'mediclaim';
        $mediclaimPendingFilter['ap_charge_status'] = 'pending';
        $opd_total_mediclaim_pending = $this->appointment_model->getAllData($mediclaimPendingFilter)->sum('ap_charge');

        $corporateFilter = $searchData;
        $corporateFilter['ap_payment_mode'] = 'corporate';
        $corporateFilter['apac_payment_mode'] = 'corporate';
        $corporateFilter['ap_charge_status'] = 'paid';
        $opd_total_corporate = $this->appointment_model->getAllData($corporateFilter)->sum('ap_charge');
        $opd_total_additional_corporate = $this->additonal_change_model->getAllData($corporateFilter)->sum('apac_final_charge');

        $corporatePendingFilter = $searchData;
        $corporatePendingFilter['ap_payment_mode'] = 'corporate';
        $corporatePendingFilter['ap_charge_status'] = 'pending';
        $opd_total_corporate_pending = $this->appointment_model->getAllData($corporatePendingFilter)->sum('ap_charge');

        return view('balance.opd.list', compact(
            'searchData',
            'opd_total_fees',
            'opd_total_additional_fees',
            'opd_total_fees_pending',
            'opd_total_cash',
            'opd_total_additional_cash',
            'opd_total_cash_pending',
            'opd_total_card',
            'opd_total_additional_card',
            'opd_total_card_pending',
            'opd_total_mediclaim',
            'opd_total_additional_mediclaim',
            'opd_total_mediclaim_pending',
            'opd_total_corporate',
            'opd_total_additional_corporate',
            'opd_total_corporate_pending'
        ));
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
        $searchData['admit_date_range'] = isset($input['date_range']) ? $input['date_range'] : '';
        $total_fees = $this->totalBillAmount($searchData);
        //$total_received_fees = $this->totalReceivedAmount($searchData);
        $total_received_fees = $this->ipd_payment_model->getList($searchData)->sum('ipl_amount');

        $cashFilter = $searchData;
        $cashFilter['ipl_received_by'] = 'cash';
        $ipd_total_cash = $this->ipd_payment_model->getList($cashFilter)->sum('ipl_amount');
        $chequeFilter = $searchData;
        $chequeFilter['ipl_received_by'] = 'cheque';
        $ipd_total_cheque = $this->ipd_payment_model->getList($chequeFilter)->sum('ipl_amount');
        $cardFilter = $searchData;
        $cardFilter['ipl_received_by'] = 'card';
        $ipd_total_card = $this->ipd_payment_model->getList($cardFilter)->sum('ipl_amount');

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
