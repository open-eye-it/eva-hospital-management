<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Appointment;

class FollowUpExport implements FromView
{
    public function __construct($input)
    {
        $this->input = $input;
        $this->appointment = new Appointment;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $searchData['search_text']  = isset($this->input['search_text']) ? $this->input['search_text'] : '';
        $searchData['follow_up_date_range']  = isset($this->input['follow_up_date_range']) ? $this->input['follow_up_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');

        $list = $this->appointment->getList($searchData, false);

        return view('appointment.export', compact('list'));
    }
}
