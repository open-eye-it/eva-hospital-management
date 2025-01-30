<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitingFee extends Model
{
    use HasFactory;

    protected $fillable = ['vf_id', 'vf_added_by', 'vf_updated_by', 'vf_case_type', 'vf_fees'];

    public function getList($filterData = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'asc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterData);
        $data->orderBy($order_by[0], $order_by[1]);
        if ($paginate === true) :
            $output = $data->paginate((int)$limit);
        else :
            $data->limit((int)$limit);
            $output = $data->get();
        endif;
        return $output;
    }

    public function singleFee($vf_id)
    {
        return static::where('vf_id', $vf_id)->first();
    }

    public function updateFee($data, $vf_id)
    {
        return static::where('vf_id', $vf_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('vf_case_type', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function CategoryData()
    {
        return $this->hasOne(UserCategory::class, 'cat_id', 'cat_id');
    }

    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'vf_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'vf_updated_by');
    }
}
