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
        'apac_final_charge'
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
}
