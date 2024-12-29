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
        'tr_documents',
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
        $search_text = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        $start_date  = isset($filterData['start_date']) ? $filterData['start_date'] : '';
        $end_date  = isset($filterData['end_date']) ? $filterData['end_date'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where(function ($query) use ($search_text) {
                $query->where('tr_real_id', 'LIKE', '%' . $search_text . '%');
                $query->orWhere('tr_name', 'LIKE', '%' . $search_text . '%');
                $query->orWhere('tr_contact_no', 'LIKE', '%' . $search_text . '%');
            });
        }
        if (isset($start_date) && $start_date != '') {
            $data->where('tr_start_date', $start_date);
        }
        if (isset($end_date) && $end_date != '') {
            $data->where('tr_end_date', $end_date);
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

    public function traineePaymentListSum(){
        return $this->hasMany(TraineePaymentList::class, 'tr_id', 'tr_id')->sum('tpl_amount');
    }
}
