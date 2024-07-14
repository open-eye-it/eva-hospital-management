<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\IpdDetail;

class IPDDetailExport implements FromView
{
    public function __construct($input)
    {
        $this->input = $input;
        $this->ipd   = new IpdDetail;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $searchData['search_text']      = isset($this->input['search_text']) ? $this->input['search_text'] : '';
        $searchData['admit_date_range'] = isset($this->input['admit_date_range']) ? $this->input['admit_date_range'] : date('Y-m-d') . ' - ' . date('Y-m-d');
        $list = $this->ipd->getList($searchData, false);

        return view('ipd.export', compact('list'));
    }
}
