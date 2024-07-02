<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Appointment;

class FollowUpController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->appointment = new Appointment;
    }

    /* Follow-Up Info */
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
}
