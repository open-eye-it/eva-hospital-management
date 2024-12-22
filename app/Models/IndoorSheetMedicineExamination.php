<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndoorSheetMedicineExamination extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'isme_id',
        'is_id',
        'ism_recommendation',
        'isme_given_datetime',
        'isme_created_datetime',
        'remark',
        'isme_added_by'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($isme_id)
    {
        return static::where('isme_id', $isme_id)->first();
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
        $isme_id  = isset($filterdata['isme_id']) ? $filterdata['isme_id'] : '';
        $is_id  = isset($filterdata['is_id']) ? $filterdata['is_id'] : '';
        if (isset($isme_id) && $isme_id != '') {
            $data->where('isme_id', $isme_id);
        }
        if (isset($is_id) && $is_id != '') {
            $data->where('is_id', $is_id);
        }
    }

    public function updateData($data, $isme_id)
    {
        return static::where('isme_id', $isme_id)->update(\Arr::only($data, $this->fillable));
    }

    public function deleteData($isme_id)
    {
        return static::where('isme_id', $isme_id)->delete();
    }

    /* Start:: Relationship */
    public function AddedByUser(){
        return $this->belongsTo(User::class, 'isme_added_by', 'user_id');
    }
    /* End:: Relationship */
}
