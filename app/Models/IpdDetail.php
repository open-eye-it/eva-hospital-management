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
        'ipd_mediclaim',
        'ipd_is_foc'
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
            $data->limit((int)$limit);
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

        if (isset($search_text) && $search_text != '') {
            $data->where('ipd_id', $search_text);
        }
    }

    public function patientExist($pa_id)
    {
        return static::where('pa_id', $pa_id)->where('ipd_status', '!=', 'admit')->first();
    }

    public function updateData($data, $ipd_id)
    {
        return static::where('ipd_id', $ipd_id)->update(\Arr::only($data, $this->fillable));
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
