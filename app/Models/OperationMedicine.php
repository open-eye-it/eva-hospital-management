<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OperationMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'om_id',
        'om_added_by',
        'om_updated_by',
        'om_name',
        'om_company_name',
        'om_description',
        'om_status',
    ];

    public function singlOperationMedicine($om_id)
    {
        return static::where('om_id', $om_id)->first();
    }

    public function insertOperationMedicine($data)
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

    public function getAllMedicine($filterData, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->filterData($data, $filterData);
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }

    public function updateOperationMedicine($data, $om_id)
    {
        return static::where('om_id', $om_id)->update(\Arr::only($data, $this->fillable));
    }

    public function updateStatus($data, $om_id)
    {
        return DB::table('operation_medicines')->where('om_id', $om_id)->update($data);
    }

    public function FilterData($data, $filterData)
    {
        $search_text = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        $om_status   = isset($filterData['om_status']) ? $filterData['om_status'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where(function ($query) use ($search_text) {
                $query->where('om_name', 'LIKE', '%' . $search_text . '%');
                $query->orWhere('om_company_name', 'LIKE', '%' . $search_text . '%');
            });
        }
        if (isset($om_status) && $om_status != '') {
            $data->where('om_status', 'LIKE', '%' . $om_status . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'om_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'om_updated_by');
    }
}
