<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'ap_id',
        'ap_doc_name',
        'ap_doc'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($id)
    {
        return static::where('id', $id)->first();
    }

    public function singlDataByWhere($where = [])
    {
        return static::where($where)->first();
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'asc'])
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

    public function FilterData($data, $filterdata)
    {
        $ap_id = isset($filterdata['ap_id']) ? $filterdata['ap_id'] : '';
        if (isset($ap_id) && $ap_id != '') {
            $data->where('ap_id', $ap_id);
        }
    }

    public function deleteData($id)
    {
        return static::where('id', $id)->delete();
    }

    public function updateData($data, $id)
    {
        return static::where('id', $id)->update(\Arr::only($data, $this->fillable));
    }
}
