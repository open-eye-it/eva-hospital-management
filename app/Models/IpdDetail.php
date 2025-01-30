<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'ipd_added_by',
        'ipd_updated_by',
        'pa_id',
        'ipd_admit_date',
        'ipd_doctor',
        'ipd_surgery_date',
        'ipd_follow_up_date',
        'ipd_follow_up_note',
        'ipd_surgery_text',
        'rm_id',
        'ipd_status',
        'ipd_discharge_date',
        'ipd_cancel_reason',
        'ipd_diagnosis',
        'ipd_investigations',
        'ipd_treatment_given',
        'ipd_treatment_discharge',
        'ipd_operation_medicine',
        'ipd_operation_medicine_date',
        'ipd_bill_amount',
        'ipd_received_amount',
        'ipd_discount',
        'ipd_discount_approved_by',
        'ipd_mediclaim',
        'ipd_is_foc',
    ];


    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($ipd_id)
    {
        return static::where('ipd_id', $ipd_id)->first();
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        $data->orderBy($order_by[0], $order_by[1]);
        if ($paginate === true) :
            $output = $data->paginate((int)$limit);
        else :
            //$data->limit((int)$limit);
            $output = $data->get();
        endif;
        return $output;
    }

    public function singleDataByColumn($arr)
    {
        return static::where($arr)->get()->first();
    }

    public function singleDataByColumnIgnoreCurrentIPDAndStatusNotRelease($arr, $ipd_id)
    {
        return static::where($arr)->where('ipd_id', '!=', $ipd_id)->where('ipd_status', 'admit')->get()->first();
    }

    public function FilterData($data, $filterdata)
    {
        $search_text    = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        $pa_id    = isset($filterdata['patient']) ? $filterdata['patient'] : '';
        $ipd_status = isset($filterdata['ipd_status']) ? $filterdata['ipd_status'] : '';
        $admit_date_range = isset($filterdata['admit_date_range']) ? $filterdata['admit_date_range'] : '';
        $follow_up_date_range = isset($filterdata['follow_up_date_range']) ? $filterdata['follow_up_date_range'] : '';
        $ipd_doctor    = isset($filterdata['ipd_doctor']) ? $filterdata['ipd_doctor'] : '';
        $doctor = isset($filterdata['doctor']) ? $filterdata['doctor'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('ipd_id', $search_text);
        }
        if (isset($pa_id) && $pa_id != '') {
            $data->where('pa_id', $pa_id);
        }
        if (isset($ipd_status) && $ipd_status != '') {
            $data->where('ipd_status', $ipd_status);
        }
        if (isset($admit_date_range) && $admit_date_range != '') {
            $dateArr = explode(' - ', $admit_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween('ipd_admit_date', $dateArr);
        }
        if (isset($follow_up_date_range) && $follow_up_date_range != '') {
            $dateArr = explode(' - ', $follow_up_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween('ipd_follow_up_date', $dateArr);
        }
        if (isset($ipd_doctor) && $ipd_doctor != '') {
            $data->where('ipd_doctor', $ipd_doctor);
        }
        if (isset($doctor) && $doctor != '') {
            $data->where('ipd_doctor', $doctor);
        }
    }

    public function totalBillAmount($filterdata)
    {
        //return static::sum('ap_charge');
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        return $data->sum('ipd_bill_amount');
    }

    public function totalReceivedAmount($filterdata)
    {
        //return static::sum('ap_additional_charge');
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        return $data->sum('ipd_received_amount');
    }

    public function patientExist($pa_id)
    {
        return static::where('pa_id', $pa_id)->where('ipd_status', 'admit')->first();
    }

    public function updateData($data, $ipd_id)
    {
        return static::where('ipd_id', $ipd_id)->update(\Arr::only($data, $this->fillable));
    }

    public function admitPatient()
    {
        return static::select('pa_id')->where('ipd_status', 'admit')->get();
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ipd_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ipd_updated_by');
    }

    public function patientData()
    {
        return $this->hasOne(Patient::class, 'pa_id', 'pa_id');
    }

    public function doctorData()
    {
        return $this->hasOne(User::class, 'user_id', 'ipd_doctor');
    }

    public function roomData()
    {
        return $this->hasOne(Room::class, 'rm_id', 'rm_id');
    }

    public function operativNoteData()
    {
        return $this->hasOne(IpdOperativeNote::class, 'ipd_id', 'ipd_id');
    }
}
