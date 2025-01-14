<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreOperativeMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'pom_id',
        'pom_added_by',
        'pom_updated_by',
        'recommendation',
        'description',
        'given_or_not',
        'pom_status'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function singlData($pom_id)
    {
        return static::where('pom_id', $pom_id)->first();
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
        if (isset($search_text) && $search_text != '') {
            $data->where('recommendation', $search_text);
        }
    }

    public function deleteData($pom_id)
    {
        return static::where('pom_id', $pom_id)->delete();
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
