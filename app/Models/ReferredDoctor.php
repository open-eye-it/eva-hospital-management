<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferredDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'rd_id',
        'rd_added_by',
        'rd_updated_by',
        'rd_name'
    ];

    public function singlData($rd_id)
    {
        return static::where('rd_id', $rd_id)->first();
    }

    public function insertData($data)
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

    public function updateData($data, $rd_id)
    {
        return static::where('rd_id', $rd_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('rd_name', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rd_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rd_updated_by');
    }
}
