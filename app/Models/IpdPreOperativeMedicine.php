<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdPreOperativeMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipom_id',
        'ipd_id',
        'pom_added_by',
        'pom_updated_by',
        'recommendation',
        'description',
        'given_or_not',
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($ipom_id)
    {
        return static::where('ipom_id', $ipom_id)->first();
    }

    public function updateData($data, $where = [])
    {
        return static::where($where)->update(\Arr::only($data, $this->fillable));
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
        $search_text = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        $ipd_id = isset($filterdata['ipd_id']) ? $filterdata['ipd_id'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('recommendation', 'LIKE', '%' . $search_text . '%');
        }
        if (isset($ipd_id) && $ipd_id != '') {
            $data->where('ipd_id', $ipd_id);
        }
    }

    public function deleteData($ipom_id)
    {
        return static::where('ipom_id', $ipom_id)->delete();
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'pom_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'pom_updated_by');
    }
}
