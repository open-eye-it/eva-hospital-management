<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class IndoorSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_id',
        'ipd_id',
        'is_added_by',
        'is_date',
        'is_findings'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($is_id)
    {
        return static::where('is_id', $is_id)->first();
    }

    public function singlDataByWhere($where)
    {
        return static::where($where)->first();
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

    public function FilterData($data, $filterdata)
    {
        $is_id  = isset($filterdata['is_id']) ? $filterdata['is_id'] : '';
        $ipd_id = isset($filterdata['ipd_id']) ? $filterdata['ipd_id'] : '';
        if (isset($is_id) && $is_id != '') {
            $data->where('is_id', $is_id);
        }
        if (isset($ipd_id) && $ipd_id != '') {
            $data->where('ipd_id', $ipd_id);
        }
    }

    public function updateData($data, $is_id)
    {
        return static::where('is_id', $is_id)->update(\Arr::only($data, $this->fillable));
    }

    public function deleteData($is_id)
    {
        return static::where('is_id', $is_id)->delete();
    }

    /* Start:: Relationship */
    public function AddedByUser(){
        return $this->belongsTo(User::class, 'is_added_by', 'user_id');
    }
    /* End:: Relationship */
}
