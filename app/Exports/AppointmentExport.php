<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Appointment;

class AppointmentExport implements FromView
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
        $searchData['ap_doctor'] = isset($this->input['ap_doctor']) ? $this->input['ap_doctor'] : '';
        $searchData['search_text']  = isset($this->input['search_text']) ? $this->input['search_text'] : '';
        $searchData['patient']  = isset($this->input['patient']) ? $this->input['patient'] : '';
        $searchData['appointment_date_range']  = isset($this->input['appointment_date_range']) ? $this->input['appointment_date_range'] : '';
        $searchData['doctor']  = isset($this->input['doctor']) ? $this->input['doctor'] : '';
        $searchData['case_type']  = isset($this->input['case_type']) ? $this->input['case_type'] : '';
        $list = $this->appointment->getList($searchData, false);

        return view('appointment.export', compact('list'));
    }
}
