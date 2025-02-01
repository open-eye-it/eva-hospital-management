<?php

namespace App\Http\Controllers\AccounDetail;

use App\Http\Controllers\MainController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;
use App\Models\AppointmentAdditionalCharge;
use App\Models\Patient;

class OPDAccountDetailController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->patient     = new Patient;
        $this->appointment = new Appointment;
        $this->additional_charge = new AppointmentAdditionalCharge;
    }

    public function index(Request $request)
    {
        $patientList = $this->patient->getList([], false);

        $input = $request->query();
        $searchData['search_text']             = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['patient']  = isset($input['patient']) ? $input['patient'] : '';
        $searchData['appointment_date_range']  = isset($input['appointment_date_range']) ? $input['appointment_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $total_fees = $this->totalFees($searchData);

        $total_additional_fees = $this->totalAdditionalFees($searchData);

        $list = $this->appointment->getList($searchData);
        return view('account-detail.opd.list', compact('list', 'patientList', 'searchData', 'total_fees', 'total_additional_fees'));
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

    /* Additional charge list for appointment */
    public function additionalChargeList(Request $request, $ap_id, $queryData = '')
    {
        $ap_id = base64_decode($ap_id);
        $list = $this->additional_charge->getAppointmentAdditionalChargeList($ap_id);
        if (count($list->toArray()) > 0) {
            // $tableRow = '';
            // foreach ($list as $charge) {
            //     $tableRow .= '<tr id="row_' . $charge->apac_id . '"><td>' . $charge->apac_id . '</td><td>' . $charge->apac_desc . '</td><td>' . $charge->apac_qty . '</td><td>' . $charge->apac_charge . '</td><td>' . $charge->apac_final_charge . '</td><td><i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge(' . $charge->apac_id . ', ' . base64_encode($ap_id) . ', ' . base64_encode($queryData) . ')"></i></td></tr>';
            // }
            $tableRow = view('account-detail.opd.additional-charge-table', compact('list', 'ap_id', 'queryData'))->render();

            return $this->getSuccessResult($tableRow, 'Additional Charge list found', true);
        } else {
            return $this->getSuccessResult('', 'Additional Charge list found', true);
        }
    }

    /* Additional Charge Store for Appointment */
    public function additionalChargeStore(Request $request)
    {
        $input = $request->query();
        $input['ap_id']             = base64_decode($input['ap_id']);
        $input['apac_final_charge'] = $input['apac_qty'] * $input['apac_charge'];
        $input['apac_id']           = $this->getUniqueID();
        $input['apac_added_by']     = Auth::user()->user_id;

        $query = json_decode($input['query']);
        //unset($input['query']);

        $insert = $this->additional_charge->insertData($input);
        if (isset($insert->apac_id)) {
            $allCharge = $this->additional_charge->appointmentFinalChargesTotal($input['ap_id']);
            $this->appointment->updateData(['ap_additional_charge' => $allCharge], $input['ap_id']);

            /* apoointment overall total with charge + additional charge */
            $inputSearch = $query;
            $searchData['search_text']            = isset($inputSearch->search_text) ? $inputSearch->search_text : '';
            $searchData['appointment_date_range'] = isset($inputSearch->appointment_date_range) ? $inputSearch->appointment_date_range : '';
            $total_fees                           = $this->totalFees($searchData);
            $total_additional_fees                = $this->totalAdditionalFees($searchData);
            $total_final                          = $total_fees + $total_additional_fees;

            /* Appointment final charge total */
            $appointment_row_additional_charge = $this->additional_charge->appointmentFinalChargesTotal($input['ap_id']);

            $data = $this->additional_charge->singlData($insert->apac_id);
            $queryData = $input['query'];
            $tableRow = view('account-detail.opd.additional-charge-single-row', compact('data', 'queryData'))->render();
            $finalData = [
                'data'        => $data,
                'total_final' => $total_final,
                'appointment_row_additional_charge' => $appointment_row_additional_charge,
                'tableRow' => $tableRow
            ];
            return $this->getSuccessResult($finalData, 'Additional Charge added', true);
        } else {
            return $this->getErrorMessage('Additional Charge not added, something is wrong.');
        }
    }

    public function additionalChargeRemove($apac_id, $ap_id, $queryData)
    {
        $apac_id = $apac_id;
        $ap_id   = base64_decode($ap_id);
        $delete = $this->additional_charge->deleteData($apac_id);
        if ($delete) {
            $allCharge = $this->additional_charge->appointmentFinalChargesTotal($ap_id);
            $this->appointment->updateData(['ap_additional_charge' => $allCharge], $ap_id);

            $inputSearch = json_decode($queryData);
            $searchData['search_text']            = isset($inputSearch->search_text) ? $inputSearch->search_text : '';
            $searchData['appointment_date_range'] = isset($inputSearch->appointment_date_range) ? $inputSearch->appointment_date_range : '';
            $total_fees                           = $this->totalFees($searchData);
            $total_additional_fees                = $this->totalAdditionalFees($searchData);
            $total_final                          = $total_fees + $total_additional_fees;

            $data = $this->additional_charge->singlData($apac_id);
            $appointment_row_additional_charge = $this->additional_charge->appointmentFinalChargesTotal($ap_id);
            $finalData = [
                'data'        => $data,
                'total_final' => $total_final,
                'appointment_row_additional_charge' => $appointment_row_additional_charge
            ];

            return $this->getSuccessResult($finalData, 'Additional charge removed', true);
        } else {
            return $this->getErrorMessage('Additional charge not removed, something is wrong.');
        }
    }

    public function getUniqueID()
    {
        $apac_id = $this->randomString(10, 'number');
        $check = $this->appointment->singlData($apac_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $apac_id;
        }
    }
}
