<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndoorSheetMedicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'ism_id',
        'is_id',
        'ism_recommendation',
        'ism_added_by'
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
        $ism_id  = isset($filterdata['ism_id']) ? $filterdata['ism_id'] : '';
        $is_id  = isset($filterdata['is_id']) ? $filterdata['is_id'] : '';
        if (isset($ism_id) && $ism_id != '') {
            $data->where('ism_id', $ism_id);
        }
        if (isset($is_id) && $is_id != '') {
            $data->where('is_id', $is_id);
        }
    }

    public function updateData($data, $ism_id)
    {
        return static::where('ism_id', $ism_id)->update(\Arr::only($data, $this->fillable));
    }

    public function deleteData($ism_id)
    {
        return static::where('ism_id', $ism_id)->delete();
    }

    /* Start:: Relationship */
    public function AddedByUser(){
        return $this->belongsTo(User::class, 'ism_added_by', 'user_id');
    }
    public function checkedByUser(){
        return $this->belongsTo(User::class, 'ism_checked_by', 'user_id');
    }
    public function indoorSheetData(){
        return $this->belongsTo(IndoorSheet::class, 'is_id', 'is_id');
    }
    /* End:: Relationship */
}
