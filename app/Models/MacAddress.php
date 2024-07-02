<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_id',
        'ma_pc_name',
        'ma_address',
        'ma_status',
        'ma_added_by',
        'ma_updated_by'
    ];

    public function singlData($ma_id)
    {
        return static::where('ma_id', $ma_id)->first();
    }

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function getList($filterdata = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
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

    public function updateData($data, $ma_id)
    {
        return static::where('ma_id', $ma_id)->update(\Arr::only($data, $this->fillable));
    }

    public function deleteData($ma_id)
    {
        return static::where('ma_id', $ma_id)->delete();
    }

    public function FilterData($data, $filterdata)
    {
        $search_text    = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('ma_pc_name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('ma_address', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ma_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ma_updated_by');
    }
}
