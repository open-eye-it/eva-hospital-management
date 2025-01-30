<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentAdditionalCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'apac_id',
        'ap_id',
        'apac_added_by',
        'apac_desc',
        'apac_qty',
        'apac_charge',
        'apac_final_charge',
        'apac_payment_mode'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($apac_id)
    {
        return static::where('apac_id', $apac_id)->get()->first();
    }

    public function deleteData($apac_id)
    {
        return static::where('apac_id', $apac_id)->delete();
    }

    public function getAppointmentAdditionalChargeList($ap_id)
    {
        return static::select('*')->where('ap_id', $ap_id)->orderBy('id', 'DESC')->get();
    }

    public function appointmentFinalChargesTotal($ap_id)
    {
        return static::where('ap_id', $ap_id)->get()->SUM('apac_final_charge');
    }

    public function getAllData($filterdata, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }

    public function FilterData($data, $filterdata)
    {
        $apac_payment_mode = isset($filterdata['apac_payment_mode']) ? $filterdata['apac_payment_mode'] : '';
        $appointment_date_range  = isset($filterdata['appointment_date_range']) ? $filterdata['appointment_date_range'] : '';

        if (isset($apac_payment_mode) && $apac_payment_mode != '') {
            $data->where('apac_payment_mode', $apac_payment_mode);
        }
        if (isset($appointment_date_range) && $appointment_date_range != '') {
            $dateArr = explode(' - ', $appointment_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween("created_at", $dateArr);
        }
    }
}
