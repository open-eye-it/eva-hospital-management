<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IpdPaymentList extends Model
{
    use HasFactory;

    protected $fillable = ['ipl_id', 'ipd_id', 'ipl_added_by', 'ipl_paid_by', 'ipl_received_by', 'ipl_amount', 'ipl_desc'];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($ipl_id)
    {
        return static::select('*', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as ipl_received_date'))->where('ipl_id', $ipl_id)->first();
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'asc'])
    {
        $data = static::select('*', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as ipl_received_date'));
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

    public function FilterData($data, $filterdata)
    {
        $ipd_id           = isset($filterdata['ipd_id']) ? $filterdata['ipd_id'] : '';
        $ipl_received_by  = isset($filterdata['ipl_received_by']) ? $filterdata['ipl_received_by'] : '';
        $admit_date_range = isset($filterdata['admit_date_range']) ? $filterdata['admit_date_range'] : '';

        if (isset($ipd_id) && $ipd_id != '') {
            $data->where('ipd_id', $ipd_id);
        }
        if (isset($ipl_received_by) && $ipl_received_by != '') {
            $data->where('ipl_received_by', $ipl_received_by);
        }
        if (isset($admit_date_range) && $admit_date_range != '') {
            $dateArr = explode(' - ', $admit_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween("created_at", $dateArr);
        }
    }

    public function deleteData($ipl_id)
    {
        return static::where('ipl_id', $ipl_id)->delete();
    }

    public function updateData($data, $ipl_id)
    {
        return static::where('ipl_id', $ipl_id)->update(\Arr::only($data, $this->fillable));
    }
}
