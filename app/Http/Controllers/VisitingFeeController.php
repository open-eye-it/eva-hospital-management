<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\VisitingFee;

class VisitingFeeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->visiting_fee = new VisitingFee;
    }

    public function index(Request $request)
    {
        $list = $this->visiting_fee->getList();
        return view('visiting_fee.list', compact('list'));
    }

    public function edit($vf_id)
    {
        $vf_id = base64_decode($vf_id);
        $data = $this->visiting_fee->singleFee($vf_id);
        return view('visiting_fee.edit', compact('data'));
    }

    public function update(Request $request, $vf_id)
    {
        $input = $request->all();
        $vf_id = base64_decode($vf_id);
        $vf_updated_by = Auth::user()->user_id;
        $input['vf_updated_by'] = $vf_updated_by;
        $user_id = $this->randomString(10, 'number');
        $data['vf_fees'] = $input['vf_fees'];
        $update = $this->visiting_fee->updateFee($data, $vf_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Visiting fees updated', true);
        } else {
            return $this->getErrorMessage('Visiting fees not updated, something is wrong.');
        }
    }
}
