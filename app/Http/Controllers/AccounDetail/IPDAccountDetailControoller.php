<?php

namespace App\Http\Controllers\AccounDetail;

use App\Http\Controllers\MainController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\IpdDetail;
use App\Models\IpdCharge;
use App\Models\IpdPaymentList;
use App\Models\Patient;

class IPDAccountDetailControoller extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->ipd = new IpdDetail;
        $this->ipd_charge = new IpdCharge;
        $this->ipd_payment = new IpdPaymentList;
        $this->patient_model = new Patient;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text']      = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['admit_date_range'] = isset($input['admit_date_range']) ? $input['admit_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $searchDataEncoded = base64_encode(json_encode($searchData));
        $list = $this->ipd->getList($searchData);

        $total_fees = $this->totalBillAmount($searchData);
        $total_received_fees = $this->totalReceivedAmount($searchData);
        return view('account-detail.ipd.list', compact('list', 'searchData', 'searchDataEncoded', 'total_fees', 'total_received_fees'));
    }

    /* Total of Charge */
    public function totalBillAmount($searchData)
    {
        $total_fees = $this->ipd->totalBillAmount($searchData);
        return $total_fees;
    }

    /* Total of Received Charge */
    public function totalReceivedAmount($searchData)
    {
        $total_fees = $this->ipd->totalReceivedAmount($searchData);
        return $total_fees;
    }

    /* Single IPD bill detail */
    public function bill_detail(Request $request, $ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $filterData['ipd_id'] = $ipd_id;
        $chargeList = $this->ipd_charge->getList($filterData, false)->toArray();
        $paymentList = $this->ipd_payment->getList($filterData, false)->toArray();
        $ipdData = $this->ipd->singlData($ipd_id);
        $patientData = $this->patient_model->singlData($ipdData->pa_id);

        $data['ipdData'] = $ipdData;
        $data['chargeList'] = $chargeList;
        $data['paymentList'] = $paymentList;
        $data['patientData'] = $patientData;


        return $this->getSuccessResult($data, 'Charge Detail', true);
    }

    /* Bill Discount Update */
    public function discount_update(Request $request)
    {
        $input = $request->all();
        $input['ipd_id'] = base64_decode($input['ipd_id']);
        $update = $this->ipd->updateData(['ipd_discount' => $input['ipd_discount'], 'ipd_discount_approved_by' => $input['ipd_discount_approved_by']], $input['ipd_id']);
        if ($update) {
            return $this->getSuccessResult([], 'Discount updated.', true);
        } else {
            return $this->getErrorMessage('Discount not update, pleaase try again.');
        }
    }

    /* Ipd Charge Add */
    public function charge_add(Request $request, $ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $input = $request->query();
        $login_user_id = Auth::user()->user_id;
        $data = [
            'ipd_id' => $ipd_id,
            'ic_text' => $input['ic_text'],
            'ic_amount' => $input['ic_amount'],
            'ic_added_by' => $login_user_id
        ];
        if ($input['ic_id'] == '') {
            $data['ic_id'] = $this->getChargeUniqueID();
            $insert = $this->ipd_charge->insertData($data);
            if ($insert->id) {
                return $this->getSuccessResult($insert, 'IPD charge added', true);
            } else {
                return $this->getErrorMessage('IPD charge not added, please try again.');
            }
        } else {
            $update = $this->ipd_charge->updateData($data, $input['ic_id']);
            if ($update == 1) {
                $charge = $this->ipd_charge->singlData($input['ic_id']);
                return $this->getSuccessResult($charge, 'IPD charge updated', true);
            } else {
                return $this->getErrorMessage('IPD charge not updated, please try again.');
            }
        }
    }

    /* Ipd Charge Remove */
    public function charge_remove($ic_id)
    {
        $ic_id = base64_decode($ic_id);
        $remove = $this->ipd_charge->deleteData($ic_id);
        return $this->getSuccessResult([], 'IPD charge removed', true);
    }

    /* Ipd Charge Single */
    public function charge_single($ic_id)
    {
        $ic_id = base64_decode($ic_id);
        $charge = $this->ipd_charge->singlData($ic_id);
        if (!empty($charge)) {
            return $this->getSuccessResult($charge, 'IPD charge found', true);
        } else {
            return $this->getErrorMessage('IPD charge not found, please try again.');
        }
    }

    /* Ipd Amount Add */
    public function payment_add(Request $request, $ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);
        $input = $request->query();
        $login_user_id = Auth::user()->user_id;
        $ipdData = $this->ipd->singleDataByColumn(['ipd_id' => $ipd_id]);
        $filterData = (array)json_decode(base64_decode($input['filterData']));
        $data = [
            'ipd_id' => $ipd_id,
            'ipl_added_by' => $login_user_id,
            'ipl_paid_by' => $input['ipl_paid_by'],
            'ipl_received_by' => $input['ipl_received_by'],
            'ipl_amount' => $input['ipl_amount'],
            'ipl_desc' => $input['ipl_desc'],
        ];
        if ($input['ipl_id'] == '') {
            $data['ipl_id'] = $this->getPaymentUniqueID();
            $insert = $this->ipd_payment->insertData($data);
            if ($insert->id) {
                $iplData = $this->ipd_payment->singlData($insert->ipl_id);
                $ipd_received_amount = $ipdData->ipd_received_amount;
                $ipd_received_amount = $ipd_received_amount + $input['ipl_amount'];
                $ipdUpdate = $this->ipd->updateData(['ipd_received_amount' => $ipd_received_amount], $ipd_id);

                $total_fees = $this->totalBillAmount($filterData);
                $total_received_fees = $this->totalReceivedAmount($filterData);

                $finalData = [
                    'total_fees' => $total_fees,
                    'total_received_fees' => $total_received_fees,
                    'iplData' => $iplData
                ];
                return $this->getSuccessResult($finalData, 'IPD payment added', true);
            } else {
                return $this->getErrorMessage('IPD payment not added, please try again.');
            }
        } else {
            $iplData = $this->ipd_payment->singlData($input['ipl_id']);
            $ipl_amount = $iplData->ipl_amount;
            $ipd_received_amount = $ipdData->ipd_received_amount;
            $ipd_received_amount = $ipd_received_amount + $input['ipl_amount'] - $ipl_amount;

            $update = $this->ipd_payment->updateData($data, $input['ipl_id']);
            if ($update == 1) {
                $ipdUpdate = $this->ipd->updateData(['ipd_received_amount' => $ipd_received_amount], $ipd_id);
                $charge = $this->ipd_payment->singlData($input['ipl_id']);

                $total_fees = $this->totalBillAmount($filterData);
                $total_received_fees = $this->totalReceivedAmount($filterData);

                $finalData = [
                    'total_fees' => $total_fees,
                    'total_received_fees' => $total_received_fees,
                    'iplData' => $charge
                ];

                return $this->getSuccessResult($charge, 'IPD payment updated', true);
            } else {
                return $this->getErrorMessage('IPD payment not updated, please try again.');
            }
        }
    }

    /* Ipd Payment Remove */
    public function payment_remove(Request $request, $ipl_id)
    {
        $input = $request->all();
        $filterData = (array)json_decode(base64_decode($input['filterData']));
        $ipl_id = base64_decode($ipl_id);
        $iplData = $this->ipd_payment->singlData($ipl_id);
        $data['ipd_id'] = $iplData->ipd_id;
        if (!empty($iplData->toArray())) {
            /* Update Received Amount */
            $ipdData = $this->ipd->singleDataByColumn(['ipd_id' => $iplData->ipd_id]);
            $ipd_received_amount = $ipdData->ipd_received_amount - $iplData->ipl_amount;
            $ipdUpdate = $this->ipd->updateData(['ipd_received_amount' => $ipd_received_amount], $iplData->ipd_id);
            /* Remove Payment */
            $remove = $this->ipd_payment->deleteData($ipl_id);

            $total_fees = $this->totalBillAmount($filterData);
            $total_received_fees = $this->totalReceivedAmount($filterData);

            $finalData = [
                'total_fees' => $total_fees,
                'total_received_fees' => $total_received_fees,
                'iplData' => $data
            ];

            return $this->getSuccessResult($finalData, 'IPD payment removed', true);
        } else {
            return $this->getErrorMessage('IPD payment not removed, please try again.');
        }
    }

    /* Ipd Payment Single */
    public function payment_single($ipl_id)
    {
        $ipl_id = base64_decode($ipl_id);
        $charge = $this->ipd_payment->singlData($ipl_id);
        if (!empty($charge)) {
            return $this->getSuccessResult($charge, 'IPD payment found', true);
        } else {
            return $this->getErrorMessage('IPD payment not found, please try again.');
        }
    }

    /* Get IPD Charge Unique ID */
    public function getChargeUniqueID()
    {
        $ic_id = $this->randomString(10, 'number');
        $check = $this->ipd_charge->singlData($ic_id);
        if (!empty($check)) {
            $this->getChargeUniqueID();
        } else {
            return $ic_id;
        }
    }

    /* Get IPD Charge Unique ID */
    public function getPaymentUniqueID()
    {
        $ipl_id = $this->randomString(10, 'number');
        $check = $this->ipd_payment->singlData($ipl_id);
        if (!empty($check)) {
            $this->getPaymentUniqueID();
        } else {
            return $ipl_id;
        }
    }

    /* Payment Receipt Print */
    public function print_receipt($ipl_id, $ipd_id)
    {
        $ipl_id = base64_decode($ipl_id);
        $ipd_id = base64_decode($ipd_id);

        $ipdDetail = $this->ipd->singlData($ipd_id);
        $iplDetail = $this->ipd_payment->singlData($ipl_id);

        $data['ipl_id'] = $iplDetail->ipl_id;
        $data['current_date'] = date('d M Y');
        $data['paid_by'] = $iplDetail->ipl_paid_by;
        $data['received_by'] = $iplDetail->ipl_received_by . ' - ' . $ipdDetail->ipl_desc;
        $data['bill_no'] = $iplDetail->ipl_id;
        $data['bill_amount'] = $iplDetail->ipl_amount;
        $data['patient_name'] = $ipdDetail->patientData->pa_name;
        $data['type_of_surgery'] = $ipdDetail->ipd_surgery_text;
        $data['admit_date'] = ($ipdDetail->ipd_admit_date != null && $ipdDetail->ipd_admit_date != '0000-00-00') ? date('d M Y', strtotime($ipdDetail->ipd_admit_date)) : '';
        $data['discharge_date'] = ($ipdDetail->ipd_discharge_date != null && $ipdDetail->ipd_discharge_date != '0000-00-00') ? date('d M Y', strtotime($ipdDetail->ipd_discharge_date)) : '';

        return response()->view('account-detail.ipd.receipt-print', compact('data'));
    }

    /* Payment Bill Print */
    public function print_bill($ipd_id)
    {
        $ipd_id = base64_decode($ipd_id);

        $ipdDetail = $this->ipd->singlData($ipd_id);
        $iplDetail = $this->ipd_payment->getList(['ipd_id' => $ipd_id]);
        $ipdChargeList = $this->ipd_charge->getList(['ipd_id' => $ipd_id]);
        return response()->view('account-detail.ipd.bill-print', compact('ipdDetail', 'iplDetail', 'ipdChargeList'));
    }
}
