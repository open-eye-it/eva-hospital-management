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
        'ap_charge_status',
        'ap_additional_charge',
        'ap_status',
        'ap_status_reaason',
        'ap_complaint',
        'ap_other_detail',
        'ap_any_advice',
        'ap_follow_up_date',
        'ap_follow_up_note',
        'ap_surg_required',
        'ap_surg_date',
        'ap_surg_type',
        'ap_is_foc',
        'ap_is_workshop',
        'ap_payment_mode',
        'ap_payment_detail',
        'pa_last_monestrual_period',
        'pa_pregnancy_no',
        'pa_miscarriages_no',
        //'pa_abortion_no',
        'pa_children_no',
        'pa_tobacco',
        'pa_smoking',
        'pa_alcohol',
        'pa_medical_history',
        'pa_family_medical_history'
    ];

    public function singlData($ap_id)
    {
        return static::where('ap_id', $ap_id)->first();
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

    public function getAllData($filterdata, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }

    public function updateData($data, $ap_id)
    {
        return static::where('ap_id', $ap_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterdata)
    {
        $search_text             = isset($filterdata['search_text']) ? $filterdata['search_text'] : '';
        $patient                 = isset($filterdata['patient']) ? $filterdata['patient'] : '';
        $appointment_date_range  = isset($filterdata['appointment_date_range']) ? $filterdata['appointment_date_range'] : '';
        $doctor                  = isset($filterdata['doctor']) ? $filterdata['doctor'] : '';
        $case_type               = isset($filterdata['case_type']) ? $filterdata['case_type'] : '';
        $ap_charge_status        = isset($filterdata['ap_charge_status']) ? $filterdata['ap_charge_status'] : '';
        $follow_up_date_range    = isset($filterdata['follow_up_date_range']) ? $filterdata['follow_up_date_range'] : '';
        $ap_doctor               = isset($filterdata['ap_doctor']) ? $filterdata['ap_doctor'] : '';
        $ap_status               = isset($filterdata['ap_status']) ? $filterdata['ap_status'] : '';
        $patient_id_phone_number = isset($filterdata['patient_id_phone_number']) ? $filterdata['patient_id_phone_number'] : '';
        $ap_payment_mode         = isset($filterdata['ap_payment_mode']) ? $filterdata['ap_payment_mode'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where(function ($query) use ($search_text) {
                $query->where('ap_id', 'LIKE', '%' . $search_text . '%')->orWhere('pa_id', 'LIKE', '%' . $search_text . '%');
            });
        }
        if (isset($patient) && $patient != '') {
            $data->where('pa_id', $patient);
        }
        if (isset($appointment_date_range) && $appointment_date_range != '') {
            $dateArr = explode(' - ', $appointment_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween('ap_date', $dateArr);
        }
        if (isset($doctor) && $doctor != '') {
            $data->where('ap_doctor', $doctor);
        }
        if (isset($case_type) && $case_type != '') {
            $data->where('ap_case_type', $case_type);
        }
        if (isset($ap_charge_status) && $ap_charge_status != '') {
            $data->where('ap_charge_status', $ap_charge_status);
        }
        if (isset($follow_up_date_range) && $follow_up_date_range != '') {
            $dateArr = explode(' - ', $follow_up_date_range);
            $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
            $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
            $data->whereBetween('ap_follow_up_date', $dateArr);
        }
        if (isset($ap_doctor) && $ap_doctor != '') {
            $data->where('ap_doctor', $ap_doctor);
        }
        if (isset($ap_status) && $ap_status != '') {
            $data->where('ap_status', $ap_status);
        }
        if (isset($patient_id_phone_number) && $patient_id_phone_number != '') {
            $data->whereHas('patientData', function ($query) use ($patient_id_phone_number) {
                $query->where('pa_id', $patient_id_phone_number);
                $query->orWhere('pa_contact_no', $patient_id_phone_number);
                $query->orWhere('pa_alt_contact_no', $patient_id_phone_number);
            });
        }
        if (isset($ap_payment_mode) && $ap_payment_mode != '') {
            $data->where('ap_payment_mode', $ap_payment_mode);
        }
    }

    public function totalFees($filterdata)
    {
        //return static::sum('ap_charge');
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        return $data->sum('ap_charge');
    }

    public function totalAdditionalFees($filterdata)
    {
        //return static::sum('ap_additional_charge');
        $data = static::select('*');
        $this->FilterData($data, $filterdata);
        return $data->sum('ap_additional_charge');
    }

    /* Patient All appointments */
    public function patientAllAppointment($pa_id)
    {
        return static::select('*')->where('pa_id', $pa_id)->orderBy('id', "DESC")->get();
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

    public function patientData()
    {
        return $this->hasOne(Patient::class, 'pa_id', 'pa_id');
    }

    public function doctorData()
    {
        return $this->hasOne(User::class, 'user_id', 'ap_doctor');
    }

    public function appointmentAdditionalChargesList()
    {
        return $this->hasMany(AppointmentAdditionalCharge::class, 'ap_id', 'ap_id');
    }
}
