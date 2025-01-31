<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\IpdDetail;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'pa_id',
        'pa_added_by',
        'pa_updated_by',
        'pa_name',
        'pa_country_code',
        'pa_dial_code',
        'pa_contact_no',
        'pa_alt_country_code',
        'pa_alt_dial_code',
        'pa_alt_contact_no',
        'pa_email',
        'pa_pan_card',
        'pa_address',
        'pa_country',
        'pa_city',
        'pa_pincode',
        'pa_state',
        'pa_dob',
        'pa_age',
        'pa_gender',
        'pa_marital_status',
        'pa_occupation',
        'pa_last_monestrual_period',
        'pa_pregnancy_no',
        'pa_miscarriages_no',
        'pa_abortion_no',
        'pa_children_no',
        'pa_photo',
        'pa_tobacco',
        'pa_smoking',
        'pa_alcohol',
        'pa_medical_history',
        'pa_family_medical_history',
        'pa_referred_by',
        'pa_referred_doctor',
        'pa_referred_text',
        'pa_status',
        'pa_blood_group'
    ];

    public function checkEmailExist($pa_email)
    {
        return static::select('pa_id')->where('pa_email', $pa_email)->where('pa_email', '!=', '')->get()->toArray();
    }

    public function checkEmailExistIgnoreID($pa_email, $pa_id)
    {
        return static::select('pa_id')->where('pa_email', $pa_email)->where('pa_email', '!=', '')->where('pa_id', '!=', $pa_id)->get()->toArray();
    }

    public function checkContactNoExist($pa_contact_no)
    {
        return static::select('pa_id')->where('pa_contact_no', $pa_contact_no)->where('pa_contact_no', '!=', '')->get()->toArray();
    }

    public function checkContactNoExistIgnoreID($pa_contact_no, $pa_id)
    {
        return static::select('pa_id')->where('pa_contact_no', $pa_contact_no)->where('pa_contact_no', '!=', '')->where('pa_id', '!=', $pa_id)->get()->toArray();
    }

    public function checkAltContactNoExist($pa_alt_contact_nO)
    {
        return static::select('pa_id')->where('pa_alt_contact_nO', $pa_alt_contact_nO)->where('pa_alt_contact_nO', '!=', '')->get()->toArray();
    }

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
            //$data->limit((int)$limit);
            $output = $data->get();
        endif;
        return $output;
    }

    public function updateData($data, $pa_id)
    {
        return static::where('pa_id', $pa_id)->update(\Arr::only($data, $this->fillable));
    }

    public function patientActiveList()
    {
        return static::where('pa_status', 1)->orderBy('id', 'DESC')->get();
    }

    public function patientWithoutIPD($admitPatientArr)
    {
        return static::whereNotIn('pa_id', $admitPatientArr)->get();
    }

    public function FilterData($data, $filterdata)
    {
        $search_text    = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        $created_at    = isset($filterdata['created_at']) ? $filterdata['created_at'] : '';
        $date = isset($filterdata['date']) ? $filterdata['date'] : '';
        $patient_id_start_month_year = isset($filterdata['patient_id_start_month_year']) ? $filterdata['patient_id_start_month_year'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('pa_id', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_contact_no', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_alt_contact_no', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('pa_email', 'LIKE', '%' . $search_text . '%');
            // $data->orWhere('pa_dob', 'LIKE', '%' . $search_text . '%');
        }
        if (isset($created_at) && $created_at != '') {
            $data->whereDate('created_at', $created_at);
        }
        if (isset($date) && $date != '') {
            $data->whereDate('created_at', '=', $date);
        }
        if (isset($patient_id_start_month_year) && $patient_id_start_month_year != '') {
            $data->where('pa_id', 'like', $patient_id_start_month_year . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'pa_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'pa_updated_by');
    }

    public function ipdAdmit()
    {
        return $this->hasOne(IpdDetail::class, 'pa_id', 'pa_id')->where('ipd_status', 'admit');
    }
}
