<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ap_id',
        'pa_id',
        'ap_added_by',
        'ap_updated_by',
        'ap_height',
        'ap_weight',
        'ap_bp',
        'ap_doctor',
        'ap_date',
        'ap_book_via',
        'ap_case_type',
        'ap_charge',
        'ap_additional_charge',
        'ap_status',
        'ap_status_reaason',
        'ap_complaint',
        'ap_other_detail',
        'ap_any_advice',
        'ap_follow_up_date',
        'ap_surg_required',
        'ap_is_foc',
        'ap_is_workshop'
    ];

    public function singlData($pa_id)
    {
        return static::where('pa_id', $pa_id)->first();
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

    public function updateData($data, $pa_id)
    {
        return static::where('pa_id', $pa_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterdata)
    {
        $search_text    = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('pa_id', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_contact_no', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_alt_contact_no', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_email', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_dob', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ap_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'ap_updated_by');
    }
}
