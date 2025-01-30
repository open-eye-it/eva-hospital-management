<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

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

    public function singleDataByName($rd_name)
    {
        return static::where('rd_name', $rd_name)->first();
    }

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function getList($filterData = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterData);
        $data->with('patientData');
        $data->orderBy($order_by[0], $order_by[1]);
        if ($paginate === true) :
            $output = $data->paginate((int)$limit);
        else :
            $data->limit((int)$limit);
            $output = $data->get();
        endif;
        return $output;
    }

    public function getSearchList($rd_name)
    {
        return static::select('rd_name')->where('rd_name', 'LIKE', '%' . $rd_name . '%')->orderBy('rd_name', 'ASC')->get();
    }

    public function updateData($data, $rd_id)
    {
        return static::where('rd_id', $rd_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text        = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        $patient_date_range = isset($filterData['patient_date_range']) ? $filterData['patient_date_range'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('rd_name', 'LIKE', '%' . $search_text . '%');
        }
        if ($patient_date_range != '') {
            $data->whereHas('patientData', function (Builder $query) use ($patient_date_range) {
                // echo $patient_date_range;
                // die;
                $dateArr = explode(' - ', $patient_date_range);
                $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
                $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));
                $query->whereDate('created_at', '>=', $dateArr[0]);
                $query->whereDate('created_at', '<=', $dateArr[1]);
            });
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

    public function patientCount()
    {
        return $this->hasMany(Patient::class, 'pa_referred_doctor', 'rd_name')->count();
    }

    public function patientData()
    {
        return $this->hasMany(Patient::class, 'pa_referred_doctor', 'rd_name');
    }
}
