<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Trainee;

class TraineePaymentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'tpl_id',
        'tr_id',
        'tpl_added_by',
        'tpl_desc',
        'tpl_amount'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($tpl_id)
    {
        return static::where('tpl_id', $tpl_id)->get()->first();
    }

    public function deleteData($tpl_id)
    {
        return static::where('tpl_id', $tpl_id)->delete();
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
        $tr_id           = isset($filterdata['tr_id']) ? $filterdata['tr_id'] : '';
        $tpl_added_by    = isset($filterdata['tpl_added_by']) ? $filterdata['tpl_added_by'] : '';
        $tpl_date_range  = isset($filterdata['tpl_date_range']) ? $filterdata['tpl_date_range'] : '';

        if (isset($tr_id) && $tr_id != '') {
            $data->where('tr_id', $tr_id);
        }
        if (isset($tpl_added_by) && $tpl_added_by != '') {
            $data->where('tpl_added_by', $tpl_added_by);
        }
        if (isset($tpl_date_range) && $tpl_date_range != '') {
            $dateArr = explode(' - ', $tpl_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween("created_at", $dateArr);
        }
    }

    /* Start:: Relationship */
    public function traineeData(){
        return $this->hasOne(Trainee::class, 'tr_id', 'tr_id');
    }
}
