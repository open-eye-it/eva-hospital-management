<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'am_id',
        'ap_id',
        'am_added_by',
        'gm_id',
        'am_days',
        'am_timing',
        'am_morning',
        'am_afternoon',
        'am_evening'
    ];

    public function singlData($am_id)
    {
        return static::where('am_id', $am_id)->first();
    }

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function deleteData($am_id)
    {
        return static::where('am_id', $am_id)->delete();
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }

    public function FilterData($data, $filterdata)
    {
        $ap_id = isset($filterdata['ap_id']) ? $filterdata['ap_id'] : '';
        if (isset($ap_id) && $ap_id != '') {
            $data->where('ap_id', $ap_id);
        }
    }

    /* Relationship */
    public function medicineData()
    {
        return $this->hasOne(GeneralMedicine::class, 'gm_id', 'gm_id');
    }
}
