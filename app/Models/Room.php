<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'rm_id',
        'rm_added_by',
        'rm_updated_by',
        'rm_building',
        'rm_floor',
        'rm_ward',
        'rm_no',
        'rm_charge',
        'rm_busy',
        'rm_status'
    ];

    public function checkBuildingFloorWardRoomExist($rm_building, $rm_floor, $rm_ward, $rm_no)
    {
        return static::where(['rm_building' => $rm_building, 'rm_floor' => $rm_floor, 'rm_ward' => $rm_ward, 'rm_no' => $rm_no])->first();
    }

    public function checkBuildingFloorWardRoomExistIgnore_rm_id($rm_id, $rm_building, $rm_floor, $rm_ward, $rm_no)
    {
        return static::where('rm_id', '!=', $rm_id)->where(['rm_building' => $rm_building, 'rm_floor' => $rm_floor, 'rm_ward' => $rm_ward, 'rm_no' => $rm_no])->first();
    }

    public function insertRoom($data)
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

    public function updateRoom($data, $rm_id)
    {
        return static::where('rm_id', $rm_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('rm_no', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('rm_charge', 'LIKE', '%' . $search_text . '%');
        }
    }

    public function singlRoom($rm_id)
    {
        return static::where('rm_id', $rm_id)->first();
    }

    public function buildingActiveList()
    {
        return static::where('rm_status', 1)->orderBy('rm_building', 'ASC')->groupBy('rm_building');
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rm_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rm_updated_by');
    }
}
