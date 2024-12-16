<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'gm_id',
        'gm_added_by',
        'gm_updated_by',
        'gm_name',
        'gm_company_name',
        'gm_description',
        'gm_status',
    ];

    public function singlGeneralMedicine($gm_id)
    {
        return static::where('gm_id', $gm_id)->first();
    }

    public function insertGeneralMedicine($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function getList($filterData = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
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

    public function getSearchList($gm_name)
    {
        return static::select('gm_id', 'gm_name')->where('gm_name', 'LIKE', '%' . $gm_name . '%')->orderBy('gm_name', 'ASC')->get();
    }

    public function getActiveList()
    {
        return static::where('gm_status', 1)->orderBy('id', 'DESC')->get();
    }

    public function updateGeneralMedicine($data, $gm_id)
    {
        return static::where('gm_id', $gm_id)->update(\Arr::only($data, $this->fillable));
    }

    public function updateStatus($data, $gm_id)
    {
        return DB::table('general_medicines')->where('gm_id', $gm_id)->update($data);
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('gm_name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('gm_company_name', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'gm_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'gm_updated_by');
    }
}
