<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdCharge extends Model
{
    use HasFactory;

    protected $fillable = ['ic_id', 'ipd_id', 'ic_added_by', 'ic_text', 'ic_amount'];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($ic_id)
    {
        return static::where('ic_id', $ic_id)->first();
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'asc'])
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

    public function FilterData($data, $filterdata)
    {
        $ipd_id    = isset($filterdata['ipd_id']) ? $filterdata['ipd_id'] : '';

        if (isset($ipd_id) && $ipd_id != '') {
            $data->where('ipd_id', $ipd_id);
        }
    }

    public function deleteData($ic_id)
    {
        return static::where('ic_id', $ic_id)->delete();
    }

    public function updateData($data, $ic_id)
    {
        return static::where('ic_id', $ic_id)->update(\Arr::only($data, $this->fillable));
    }
}
