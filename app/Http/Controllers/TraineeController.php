<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Trainee;

use Illuminate\Support\Facades\Storage;

use PDF;

class TraineeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->trainee = new Trainee();
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $searchData['search_text'] = isset($input['search_text']) ? $input['search_text'] : '';
        $searchData['start_date']  = isset($input['start_date']) ? $input['start_date'] : '';
        $searchData['end_date']    = isset($input['end_date']) ? $input['end_date'] : '';
        $list = $this->trainee->getList($searchData);
        return view('trainee.list', compact('list', 'searchData'));
    }

    public function create()
    {
        $tr_real_id = $this->traineedID();
        return view('trainee.create', compact('tr_real_id'));
    }

    public function store(Request $request, $tr_real_id)
    {
        $input = $request->all();
        $tr_id = $this->getUniqueID();
        $tr_real_id = base64_decode($tr_real_id);
        $login_user_id = Auth::user()->user_id;

        $file_data = [];
        if ($request->hasFile('tr_documents')) {
            foreach ($request->file('tr_documents') as $file) {

                $file = UploadCustomeImage($file, $tr_real_id . '-' . $this->randomString(10, 'number'));
                $file_data[] = $file;
            }
        }

        $data = [
            'tr_id' => $tr_id,
            'tr_added_by' => $login_user_id,
            'tr_updated_by' => $login_user_id,
            'tr_real_id' => $tr_real_id,
            'tr_name' => (string)$input['tr_name'],
            'tr_address' => (string)$input['tr_address'],
            'tr_contact_no' => $input['tr_contact_no'],
            'tr_start_date' => $input['tr_start_date'],
            'tr_end_date' => $input['tr_end_date'],
            'tr_total_amount' => $input['tr_total_amount'],
            'tr_paid_amount' => $input['tr_paid_amount'],
            'tr_is_advance_received' => $input['tr_is_advance_received'],
            'tr_advance_received_date' => $input['tr_advance_received_date'],
            'tr_remarks' => (string)$input['tr_remarks'],
        ];

        if (count($file_data) > 0) {
            $data['tr_documents'] = json_encode($file_data);
        }

        $insert = $this->trainee->insertTrainee($data);
        if (isset($insert->tr_id)) {
            return $this->getSuccessResult([], $input['tr_name'] . ' added as trainee', true);
        } else {
            return $this->getErrorMessage($input['tr_name'] . ' not added as trainee, something is wrong.');
        }
    }

    public function edit($tr_id)
    {
        $tr_id = base64_decode($tr_id);
        $data = $this->trainee->singlTrainee($tr_id);
        if (!empty($data)) {
            return view('trainee.edit', compact('data'));
        } else {
            return redirect()->route('trainee.list');
        }
    }

    public function update(Request $request, $tr_id)
    {
        $input = $request->all();
        $tr_id = base64_decode($tr_id);
        $data = $this->trainee->singlTrainee($tr_id);
        if (!empty($data)) {
            $login_user_id = Auth::user()->user_id;

            $file_data = [];
            if ($request->hasFile('tr_documents')) {
                foreach ($request->file('tr_documents') as $file) {

                    $file = UploadCustomeImage($file, $data->tr_real_id . '-' . $this->randomString(10, 'number'));
                    $file_data[] = $file;
                }
            }

            if (isset($input['file_old'])) {
                $old_file = json_decode($data->tr_documents);
                foreach ($old_file as $list) {
                    if (!in_array($list, $input['file_old'])) {
                        ImageRemove($list);
                    }
                }
                $file_data = array_merge($file_data, $input['file_old']);
            } else {
                if ($data->tr_documents != '') {
                    $old_file = json_decode($data->tr_documents);
                    foreach ($old_file as $list) {
                        Storage::disk('public')->delete($list);
                    }
                }
            }

            $data = [
                'tr_updated_by' => $login_user_id,
                'tr_name' => (string)$input['tr_name'],
                'tr_address' => (string)$input['tr_address'],
                'tr_contact_no' => $input['tr_contact_no'],
                'tr_start_date' => $input['tr_start_date'],
                'tr_end_date' => $input['tr_end_date'],
                'tr_total_amount' => $input['tr_total_amount'],
                'tr_paid_amount' => $input['tr_paid_amount'],
                'tr_is_advance_received' => $input['tr_is_advance_received'],
                'tr_advance_received_date' => $input['tr_advance_received_date'],
                'tr_remarks' => (string)$input['tr_remarks'],

            ];
            if (count($file_data) > 0) {
                $data['tr_documents'] = json_encode($file_data);
            } else {
                $data['tr_documents'] = '';
            }
            $update = $this->trainee->updateTrainee($data, $tr_id);
            if ($update == 1) {
                return $this->getSuccessResult([], $input['tr_name'] . ' updated as trainee', true);
            } else {
                return $this->getErrorMessage($input['tr_name'] . ' not updated as trainee, something is wrong.');
            }
        } else {
            return $this->getErrorMessage('Trainee not found.');
        }
    }

    public function viewTrainee($tr_id)
    {
        $tr_id = base64_decode($tr_id);
        $data = $this->trainee->singlTrainee($tr_id);
        if (!empty($data)) {
            $data1 = $data->toArray();
            $added_by = $data->AddedByData->person_name;
            $data1['tr_added_by'] = $added_by;
            $updated_by = $data->UpdatedByData->person_name;
            $data1['tr_updated_by'] = $updated_by;
            return $this->getSuccessResult($data1, 'Trainee detail found', true);
        } else {
            return $this->getErrorMessage('Trainee detail not found');
        }
    }

    public function status($encoded_id)
    {
        $decoded_id = base64_decode($encoded_id);
        $idArr = explode('[]', $decoded_id);
        $data = [
            'tr_status' => $idArr[1],
            'tr_reason_cancel' => $idArr[2]
        ];
        $update = $this->trainee->updateTrainee($data, $idArr[0]);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Status changed', true);
        } else {
            return $this->getErrorMessage('Status not changed, something is wrong.');
        }
    }

    public function downloadFile($fileName)
    {
        $fileName1 = base64_decode($fileName);
        return response()->download(storage_path('app/public/' . $fileName1));
    }

    public function certificatePDF($tr_id)
    {
        $tr_id = base64_decode($tr_id);
        $data = $this->trainee->singlTrainee($tr_id);
        if (!empty($data)) {
            $data = ['data' => $data];
            $pdf = PDF::loadView('trainee.pdf-view', $data);
            return $pdf->download('trainee-' . $tr_id . '-' . date('YmdHis') . '.pdf');
        } else {
            return redirect()->route('trainee.list');
        }
    }

    public function traineedID()
    {
        $tr_real_id = date('YmdH') . $this->randomString(6, 'number');
        $check = $this->trainee->traineeIDExist($tr_real_id);
        if (!empty($check)) {
            $this->traineedID();
        } else {
            return $tr_real_id;
        }
    }

    public function getUniqueID()
    {
        $tr_id = $this->randomString(10, 'number');
        $check = $this->trainee->singlTrainee($tr_id);
        if (!empty($check)) {
            $this->getUniqueID();
        } else {
            return $tr_id;
        }
    }
}
