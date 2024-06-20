<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $fillable = [
        'tr_id',
        'tr_added_by',
        'tr_updated_by',
        'tr_real_id',
        'tr_name',
        'tr_address',
        'tr_contact_no',
        'tr_start_date',
        'tr_end_date',
        'tr_total_amount',
        'tr_paid_amount',
        'tr_is_advance_received',
        'tr_advance_received_date',
        'tr_remarks',
        'tr_status',
        'tr_reason_cancel'
    ];

    public function singlTrainee($tr_id)
    {
        return static::where('tr_id', $tr_id)->first();
    }

    public function traineeIDExist($tr_real_id)
    {
        return static::where('tr_real_id', $tr_real_id)->first();
    }

    public function insertTrainee($data)
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

    public function updateTrainee($data, $tr_id)
    {
        return static::where('tr_id', $tr_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('tr_real_id', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('tr_name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('tr_contact_no', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'tr_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'tr_updated_by');
    }
}
