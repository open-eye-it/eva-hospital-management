<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_id',
        'ap_id',
        'ipd_id',
        'no_type',
        'no_subject',
        'no_message',
        'no_icon',
        'no_action',
        'no_created_for',
        'no_created_by',
        'no_read'
    ];

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function updateData($data, $no_id)
    {
        return static::where('no_id', $no_id)->update(\Arr::only($data, $this->fillable));
    }

    public function getList($filterData, $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->filterData($data, $filterData);
        $data->orderBy($order_by[0], $order_by[1]);
        if ($paginate === true) :
            $output = $data->paginate((int)$limit);
        else :
            $output = $data->get();
        endif;
        return $output;
    }

    public function FilterData($data, $filterdata)
    {
        $no_created_for = isset($filterdata['no_created_for']) ? $filterdata['no_created_for'] : '';
        $no_read        = isset($filterdata['no_read']) ? $filterdata['no_read'] : '';

        if (isset($no_created_for) && $no_created_for != '') {
            $data->where('no_created_for', $no_created_for);
        }
        if (isset($no_read) && $no_read != '') {
            $data->where('no_read', $no_read);
        }
    }
}
